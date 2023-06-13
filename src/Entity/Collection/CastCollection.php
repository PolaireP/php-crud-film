<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Cast;
use PDO;

class CastCollection
{
    /**
     * Retourne un tableau contenant tous les casts triés par ordre des ids
     *
     * @return Cast[]
     */
    public function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<SQL
            SELECT id, movieId, peopleId, role, orderIndex
            FROM cast
            ORDER BY id
        SQL
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Cast::class);
    }
}