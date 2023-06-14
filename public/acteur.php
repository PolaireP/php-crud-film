<?php

declare(strict_types=1);

use Entity\Collection\CastCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Film;
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
        $urlImg = "img/actor.png";
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

    // Fermeture de la div infos_acteur et details_acteur
    $webpage->appendContent("</div></div>");

    // Liste des films dans lequelle la personne a eu un rôle

    $listeCastsActeur = CastCollection::findByPeopleId($peopleId);
    // Début liste des films dans lequelle a joué la personne
    $webpage->appendContent("<ul class='liste_details_film'>");

    foreach ($listeCastsActeur as $cast) {
        $film = Film::findById($cast->getMovieId());

        if ($film->getPosterId() == null) {
            $urlImg = "img/movie.png";
        } else {
            $urlImg = "image.php?imageId={$film->getPosterId()}";
        }

        $webpage->appendContent(
            <<<HTML
            <div class="poster">
                <img src="$urlImg">
            </div>
            <div class="infos_film">
                <div class="info_film_partie_sup">
                    <div class="info_titre_film">{$film->getTitle()}</div>
                    <div class="info_titre_date">{$film->getReleaseDate()}</div>
                </div>
                <div class="info_film_partie_inf">
                    <div class="info_role">{$cast->getRole()}</div>
                </div>
            </div>
            HTML
        );

    }

    // Fin liste film
    $webpage->appendContent("</ul>");
    echo $webpage->toHTML();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}