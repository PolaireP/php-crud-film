<?php
declare(strict_types=1);

use Html\AppWebpage;
use Entity\Collection\FilmCollection;
use Entity\Image;

$webpage = new AppWebpage('Films');

$webpage->appendCssUrl("css/style.css");

$webpage->appendContent(
    <<<HTML
    <button class="createFilm" type="button">
        <a href="createFilm.php">Ajouter film</a>
    </button>
HTML
);

$films = FilmCollection::findAll();

foreach ($films as $movie) {
    $webpage->appendContent(
        '<a class="movieCard" href="film.php?movieId='. $movie->getid(). '"><img src="image.php?imageId='. $movie->getPosterId() .'"><h3 class="movieImage">'. $movie->getTitle() .'</h3></a>'. "\n");
}

$webpage->getLastModification();

echo $webpage->toHTML();
