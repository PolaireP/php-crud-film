<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Cast;
use Entity\Exception\EntityNotFoundException;
use PDO;

class CastCollection
{
    /**
     * Retourne un tableau contenant tous les casts triés par ordre des ids
     *
     * @return Cast[]
     */
    public static function findAll(): array
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

    public static function findByMovieId(int $movieId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<SQL
            SELECT id, movieId, peopleId, role, orderIndex
            FROM cast
            WHERE movieId = :movieId
        SQL
        );

        $stmt->execute([':movieId' => $movieId]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, Cast::class);
    }

    public static function findByPeopleId(int $peopleId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<SQL
            SELECT id, movieId, peopleId, role, orderIndex
            FROM cast
            WHERE peopleId = :peopleId
        SQL
        );

        $stmt->execute([':peopleId' => $peopleId]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, Cast::class);
    }

}