<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;
use Entity\Exception\EntityNotFoundException;
class Image
{
    private int $id;
    private string $jpeg;

    /**
     * @return int
     */
    public  function getId(): int{
        return $this->id;
    }/**
     * @return string
     */
    public  function getJpeg(): string{
        return $this->jpeg;
    }

    /**
    * @param int $id
    * @return Image
     */
    public static function findbyId(int $id) : Image {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM image
            WHERE id = :id;
            SQL
        );

        $stmt -> execute([":id" => $id]);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, Image::class);
        if (($request = $stmt->fetch()) !== false) {
            return $request;
        } else {
            throw new EntityNotFoundException('Image introuvable');
        }
    }
}