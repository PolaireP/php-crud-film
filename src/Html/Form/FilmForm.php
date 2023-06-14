<?php
declare(strict_types=1);

namespace Html\Form;

use Entity\Film;
use Entity\GenreCollection;
use Entity\Exception\ParameterException;
use Html\Form\Html\StringEscaper;

class FilmForm

{
    use Html\Form\Html\StringEscaper;
    private ?Film $film;

    /**
     * @param Film|null $film
     */
    public function __construct(?Film $film)
    {
        $this->film = $film;
    }

    /**
     * @return Film|null
     */
    public  function getFilm(): ?Film{
        return $this->film;
    }

    public function getHtmlForm(string $action) : string {

        $genres = GenreCollection::findAll();
        $genreChoices = <<<HTML
            <fieldset>
                <legend>Choix des genres</legend>
            HTML;

        foreach ($genres as $elem) {
            $genreChoices = $genreChoices.
                <<<HTML
        
            <div>
                <input type="checkbox" name="genres[]" value="{$elem->getId()}">
                <label>{$elem->getName()}</label>
            </div>

        HTML;}
        $genreChoices = $genreChoices. '</fieldset>';

        return $main = <<<HTML
                <form method="post" action="{$action}">
                    <div><label>Titre :</label><input type="text" name="title"></div>
                    <div><label>Langue originale :</label><input name="originalLanguage" type="text" required></div>
                    <div><label>Titre original :</label><input type="text" name="originalTitle" required></div>
                    <div><label>Description :</label><input type="text" name="overview" required></div>
                    <div><label>Date de sortie :</label><input type="date" name="releaseDate"></div>
                    <div><label>Temps d'écran :</label><input type="number" name="runtime"></div>
                    <div><label>Tags :</label><input type="text" name="tagline"></div>
                    {$genreChoices}
                    <input type="submit">
                </form>
            HTML;
    }



}