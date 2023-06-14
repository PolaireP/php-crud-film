<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\WebPage;
use Entity\Image;

try {
    if (!isset($_GET['imageId']) || !is_numeric($_GET['imageId'])){
        throw new ParameterException('Paramètre incorrect');
    }
    $img = Image::findById(intval($_GET['imageId']));
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}

header('Content-Type: image/jpeg');
echo($img->getJpeg());