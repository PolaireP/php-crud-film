<?php
declare(strict_types=1);

use Entity\Film;

if (!isset($_GET['movieId']) || !is_numeric($_GET['movieId'])) {
    throw new ParameterException('Identifiant de film invalide');
    exit();
}

$film = Film::findById(intval($_GET['movieId']));
$film->delete();

header('Location: index.php', response_code: 301);

