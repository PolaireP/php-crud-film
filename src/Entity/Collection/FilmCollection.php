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
}