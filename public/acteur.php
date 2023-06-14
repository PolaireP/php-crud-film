<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Image;
use Entity\People;
use Html\AppWebpage;

try {
    if (!isset($_GET['peopleId']) || !is_numeric($_GET['peopleId'])) {
        throw new ParameterException('Paramètre incorrect');
    }
    $peopleId = intval(preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET['peopleId']));
    $people = People::findById(intval($_GET['peopleId']));

    $webpage = new AppWebPage();
    $webpage->setTitle($webpage->escapeString("Films - {$people->getName()}"));



    echo $webpage->toHTML();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}