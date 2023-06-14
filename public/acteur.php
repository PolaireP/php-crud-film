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

    if ($people->getAvatarId() == null) {
        $urlImg = "";
    } else {
        $urlImg = "image.php?imageId={$people->getAvatarId()}";
    }

    $webpage->appendContent(
        <<<HTML
        <div class="details_acteur">
            <div class="vignette_acteur">
                <img src="$urlImg">
            </div>
            <div class="infos_acteur">
                <div class="nom">{$people->getName()}</div>
        HTML
    );

    // Si le lieu de naissance n'est pas nulle on l'affiche
    if ($people->getPlaceOfBirth() !== null) {
        $webpage->appendContent("<div class='lieu_naissance'>{$people->getPlaceOfBirth()}</div>");
    }

    $webpage->appendContent("<div class='date'>");

    // Si la date de naissance est renseignée l'affiché
    if ($people->getBirthday() !== null) {
        $webpage->appendContent("<div class='date_naissance'>{$people->getBirthday()}</div>");
    }

    // Si la date de décès est renseignée l'affiché
    if ($people->getDeathday() !== null) {
        $webpage->appendContent(" - <div class='date_mort'>{$people->getDeathday()}</div>");
    }

    // Fermeture de la div date
    $webpage->appendContent("</div>");

    // Si la biographie est renseignée l'affiché
    if ($people->getBiography() !== null) {
        $webpage->appendContent("<div class='biographie'>{$people->getBiography()}</div>");
    }

    $webpage->appendContent("</div></div>");

    echo $webpage->toHTML();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}