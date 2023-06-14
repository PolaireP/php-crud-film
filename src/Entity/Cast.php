<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Cast
{
    private ?int $id;
    private int $movieId;
    private int $peopleId;
    private string $role;
    private int $orderIndex;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * @param int $movieId
     */
    public function setMovieId(int $movieId): void
    {
        $this->movieId = $movieId;
    }



    /**
     * @return int
     */
    public function getPeopleId(): int
    {
        return $this->peopleId;
    }

    /**
     * @param int $peopleId
     */
    public function setPeopleId(int $peopleId): void
    {
        $this->peopleId = $peopleId;
    }



    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }



    /**
     * @return int
     */
    public function getOrderIndex(): int
    {
        return $this->orderIndex;
    }

    /**
     * @param int $orderIndex
     */
    public function setOrderIndex(int $orderIndex): void
    {
        $this->orderIndex = $orderIndex;
    }



    public function delete(): Cast
    {

        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        DELETE FROM cast
        WHERE id = :id
        SQL
        );

        $stmt->execute([':id' => $this->id]);
        $this->setId(null);

        return $this;
    }

    protected function update(): Cast
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            UPDATE cast
            SET movieId = :movieId,
                peopleId = :peopleId,
                role = :role,
                orderIndex = :orderIndex
            WHERE id = :id
            SQL
        );

        $stmt->execute([':id' => $this->id,
            ':movieId' => $this->movieId,
            ':peopleId' => $this->peopleId,
            ':role' => $this->role,
            ':orderIndex' => $this->orderIndex]);

        return $this;
    }

    protected function insert(): Cast
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            INSERT INTO cast (movieId, peopleId, role, orderIndex)
            VALUES (:movieId, :peopleId, :role, :orderIndex)
        SQL
        );

        $stmt->execute([':movieId' => $this->movieId,
                        ':peopleId' => $this->peopleId,
                        ':role' => $this->role,
                        ':orderIndex' => $this->orderIndex]);
        $this->id = intval(MyPdo::getInstance()->lastInsertId());

        return $this;
    }

    public static function create(?int $id, int $movieId, int $peopleId, string $role, int $orderIndex): Cast
    {
        $cast = new Cast();
        $cast->setId($id);
        $cast->setMovieId($movieId);
        $cast->setPeopleId($peopleId);
        $cast->setRole($role);
        $cast->setOrderIndex($orderIndex);
        return $cast;
    }

    public function save(): void
    {
        if ($this->id === null) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    public static function findById(int $id): Cast
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<SQL
            SELECT id, movieId, peopleId, role, orderIndex
            FROM cast
            WHERE id = :id
        SQL
        );

        $stmt->execute([':id' => $id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Cast::class);
        if (($object = $stmt->fetch()) !== false) {
            return $object;
        } else {
            throw new EntityNotFoundException('Cast introuvable');
        }
    }
}
