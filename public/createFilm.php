<?php
declare(strict_types=1);

use Html\AppWebpage;
use Html\Form\FilmForm;

$webpage = new AppWebpage('Ajouter un film');
$webpage ->appendContent(FilmForm::getHtmlForm('addFilm.php'));

echo $webpage->toHTML();