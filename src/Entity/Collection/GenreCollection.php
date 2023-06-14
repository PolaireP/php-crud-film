<?php
declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use PDO;
use Entity\Film;
use Entity\Genre;
class GenreCollection
{

    /**
    * @param int $id
    * @return array
     */
    public static function findByMovieId(int $id) : array {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
                SELECT *
                FROM genre g
                JOIN movie_genre m ON m.genreId = g.id
                WHERE m.movieId = :movieId
            SQL);

        $stmt->execute([':movieId' => $id]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, Genre::class);
    }

    /**
    * @return array
     */
    public static function findAll() : array {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
                SELECT *
                FROM genre
            SQL);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Genre::class);
    }

    public static function createMovieGenre(int $movieId, int $genreId) {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
                    INSERT INTO movie_genre (movieId, genreId)
                    VALUES (:movieId, :genreId)
                SQL
        );
        $stmt->execute([':movieId' => $movieId, ':genreId' => $genreId]);
    }

    public static function deleteMovieGenre(int $movieId, int $genreId) {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
                    DELETE
                    FROM movie_genre
                    WHERE movieId = :movieId AND genreId = :genreId
                SQL
        );
        $stmt->execute([':movieId' => $movieId, ':genreId' => $genreId]);
    }
}