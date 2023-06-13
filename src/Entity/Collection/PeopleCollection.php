<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use PDO;
use Entity\People;

class PeopleCollection
{
    /**
     * Retourne un tableau contenant toutes les personnes triés par ordre alphabétique
     *
     * @return People[]
     */
    public function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<SQL
            SELECT id, avatarId, DATE_FORMAT(birthday, '%d/%m/%Y') AS birthday, DATE_FORMAT(deathday, '%d/%m/%Y') AS deathday, name, biography, placeOfBirth
            FROM people
            ORDER BY name
        SQL
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, People::class);
    }
}