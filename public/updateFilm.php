<?php
declare(strict_types=1);

use Entity\Film;
use Html\Form\FilmForm;
use Entity\Collection\GenreCollection;

$form = new FilmForm(null);
$form->setEntityFromQueryString();
$form->getFilm()->save();

$genres = $_POST['genres'];
$checkedGenresId = array();
$checkedGenres = GenreCollection::findByMovieId($form->getFilm()->getId());

foreach ($checkedGenres as $elem) {
    array_push($checkedGenresId, $elem->getId());
}

/** Vérification des genres encore présents et suppression des genrs non présents*/

foreach ($checkedGenresId as $id) {
    if (!in_array($id, $genres)){
        GenreCollection::deleteMovieGenre($form->getFilm()->getId(), $id);

    }
}

/** Mise à jour des genres présents */
$checkedGenres = GenreCollection::findByMovieId($form->getFilm()->getId());

foreach ($checkedGenres as $elem) {
    array_push($checkedGenresId, $elem->getId());
}

/** Ajout des nouveaux genres */

foreach ($genres as $id) {
    if (!in_array($id, $checkedGenresId)){
    GenreCollection::createMovieGenre($form->getFilm()->getId(), intval($id));}
}