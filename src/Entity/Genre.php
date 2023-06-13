<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;
use Entity\Exception\EntityNotFoundException;

class Genre
{
    private int $id;
    private string $name;

    public function findbyId(int $id) {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM genre
            WHERE $id = :id;
            SQL
        );

        $stmt -> execute([":id" => $id]);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, Genre::class);
        if (($request = $stmt->fetch()) !== false) {
            return $request;
        } else {
            throw new EntityNotFoundException('Genre introuvable');
        }
    }
}