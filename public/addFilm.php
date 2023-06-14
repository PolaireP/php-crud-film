<?php
declare(strict_types=1);

use Entity\Film;
use Html\Form\FilmForm;
use Entity\Collection\GenreCollection;
use Database\MyPdo;

$form = new FilmForm(null);
$form -> setEntityFromQueryString();
$form->getFilm()->save();

$movieId = intval(MyPdo::getInstance()->lastInsertId());
$genres = $_POST['genres'];

foreach ($genres as $key => $elem) {
    GenreCollection::createMovieGenre($movieId, intval($elem));
}