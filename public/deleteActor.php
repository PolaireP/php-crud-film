<?php
declare(strict_types=1);

use Html\Form\CastForm;
use Html\AppWebpage;

if (!isset($_GET['movieId']) || !is_numeric($_GET['movieId'])) {
    throw new \Entity\Exception\ParameterException('Paramètre invalide');
    exit();
}

$webpage = new AppWebpage('Ajouter un acteur');
$form = new CastForm(null);
$webpage ->appendContent(CastForm::getDeleteHtmlForm('unlinkActor.php', intval($_GET['movieId'])));

echo $webpage->toHTML();