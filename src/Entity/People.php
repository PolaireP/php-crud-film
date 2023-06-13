<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class People
{
    private int $avatarId;
    private int $id;
    private string $birthday;
    private ?string $deathday;
    private string $name;
    private string $biography;
    private string $placeOfBirth;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->birthday;
    }

    /**
     * @return string
     */
    public function getDeathday(): string
    {
        return $this->deathday;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /**
     * @return string
     */
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }

    public static function findById(int $id): People
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, avatarId, DATE_FORMAT(birthday, '%d/%m/%Y') AS birthday, DATE_FORMAT(deathday, '%d/%m/%Y') AS deathday, name, biography, placeOfBirth
            FROM people
            WHERE id = :id
            ORDER BY name
        SQL
        );

        $stmt->execute([':id' => $id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, People::class);
        if (($object = $stmt->fetch()) !== false) {
            return $object;
        } else {
            throw new EntityNotFoundException('Personne introuvable');
        }
    }
}
