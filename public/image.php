<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\WebPage;
use Entity\Cover;

try {
    ///////////////////////
    // À vous de jouer ! //
    ///////////////////////
    if (!isset($_GET['coverId']) || !is_numeric($_GET['coverId'])){
        throw new ParameterException('Paramètre incorrect');
    }
    $couverture = Image::findById(intval($_GET['coverId']));
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}

header('Content-Type: image/jpeg');
echo($couverture->getJpeg());