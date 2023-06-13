<?php
declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use PDO;
use Entity\Film;

class FilmCollection
{

    /**
    * @return array
     */
    public function findAll(): array {

        $request = MyPdo::getInstance()->prepare(
            <<<SQL
                SELECT *
                FROM film
            SQL);

            $request->execute();

            return $request->fetchAll(PDO::FETCH_CLASS, Film::class);
    }

    /**
    * @param int $id
    * @return array
     */
    public function findByGenreId(int $id): array {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
                SELECT *
                FROM film f
                JOIN movie_genre m ON m.movieId = f.id
                WHERE m.genreId = :genreId
            SQL);

        $request->execute([':genreId' => $id]);

        return $request->fetchAll(PDO::FETCH_CLASS, Film::class);
    }
}