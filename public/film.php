<?php

declare(strict_types=1);

use Entity\Collection\CastCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Film;
use Entity\People;
use Html\AppWebpage;

try {
    if (!isset($_GET['movieId']) || !is_numeric($_GET['movieId'])) {
        throw new ParameterException('Paramètre incorrect');
    }
    $movieId = intval(preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET['movieId']));
    $movie = Film::findById(intval($_GET['movieId']));

    $webpage = new AppWebPage();
    $webpage->setTitle($webpage->escapeString("Films - {$movie->getTitle()}"));

    $webpage->appendCssUrl("css/page.css");

    if (($movie->getPosterId()) === null) {
        $image = '/img/movie.png';
    } else {
        $image = 'image.php?imageId='.$movie->getPosterId();
    }

    $webpage->appendContent(
        <<<HTML
        <div class="details_film">
            <div class="poster_film">
                <img src="{$image}">
            </div>
            <div class="infos_film">
                <div class="infos_film_titre_date">
                    <div class="infos_film_titre">{$movie->getTitle()}</div>
                    <div class="infos_film_date">{$movie->getReleaseDate()}</div>
                </div>
                <div class="titre_original">{$movie->getOriginalTitle()}</div>
                <div class="slogan">{$movie->getTagline()}</div>
                <div class="resume">{$movie->getOverview()}</div>
            </div>  
        </div> 
        HTML
    );

    $listeCastsActeur = CastCollection::findByMovieId($movieId);

    $webpage->appendContent("<ul class='liste_acteurs_film'>");

    foreach ($listeCastsActeur as $cast) {
        $people = People::findById($cast->getPeopleId());

        if ($people->getAvatarId() === null) {
            $actorImage = '/img/actor.png';
        } else {
            $actorImage = 'acteur.php?peopleId='. $people->getAvatarId();
        }
        $webpage->appendContent(
            <<<HTML
            <li>
                <a href="acteur.php?peopleId={$people->getId()}">
                    <div class="profile_acteur">
                        <img src="{$actorImage}">
                    </div>
                    <div class="infos_acteur">
                        <div class="role_acteur">Rôle : {$cast->getRole()}</div>
                        <div class="nom_acteur">Nom : {$people->getName()}</div>
                    </div>
                </a>
            </li>
            HTML
        );
    }
    $webpage->appendContent("</ul>");

    echo $webpage->toHTML();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}