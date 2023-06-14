<?php
declare(strict_types=1);

use Html\AppWebpage;
use Html\Form\FilmForm;
use Entity\Film;
use Entity\Exception\ParameterException;

if (!isset($_GET['movieId']) || !is_numeric($_GET['movieId'])) {
    throw new ParameterException('Identifiant de film invalide');
    exit();
}

$webpage = new AppWebpage('Edition de film');
$form = new FilmForm(Film::findById(intval($_GET['movieId'])));

$webpage ->appendContent($form->getEditHtmlForm('updateFilm.php'));
echo $webpage->toHTML();
