<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;

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
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * @return int
     */
    public function getPeopleId(): int
    {
        return $this->peopleId;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return int
     */
    public function getOrderIndex(): int
    {
        return $this->orderIndex;
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
        return $this;
    }

    protected function insert(): Cast
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            INSERT INTO cast (id, movieId, peopleId, role, orderIndex)
            VALUES (:id, :movieId, :peopleId, :role, :orderIndex)
        SQL
        );

        $stmt->execute([':id' => $this->id,
                        ':movieId' => $this->movieId,
                        ':peopleId' => $this->peopleId,
                        ':role' => $this->role,
                        ':orderIndex' => $this->orderIndex]);
        $this->id = intval(MyPdo::getInstance()->lastInsertId());

        return $this;
    }
}
