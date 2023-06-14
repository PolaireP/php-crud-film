<?php
declare(strict_types=1);

namespace Html\Form;

use Entity\Film;
use Entity\Collection\GenreCollection;
use Entity\Exception\ParameterException;
use Html\Form\Html\StringEscaper;

class FilmForm

{
    use StringEscaper;
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

    public static function getHtmlForm(string $action) : string {

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


    public function getEditHtmlForm(string $action) : string {

        $genres = GenreCollection::findAll();
        $checkedGenresId = array();
        $checkedGenres = GenreCollection::findByMovieId($this->film->getId());

        foreach ($checkedGenres as $elem) {
            array_push($checkedGenresId, $elem->getId());
        }

        $genreChoices = <<<HTML
    <fieldset>
        <legend>Choix des genres</legend>
    HTML;



        foreach ($genres as $elem) {
            if (in_array($elem->getId(), $checkedGenresId)) {
                $genreChoices = $genreChoices.
                    <<<HTML

                    <div>
                        <input type="checkbox" name="genres[]" value="{$elem->getId()}" checked>
                        <label>{$elem->getName()}</label>
                    </div>
                HTML;
            } else {
            $genreChoices = $genreChoices.
                <<<HTML

                    <div>
                        <input type="checkbox" name="genres[]" value="{$elem->getId()}">
                        <label>{$elem->getName()}</label>
                    </div>
                HTML;
            }
        }
        $genreChoices = $genreChoices. '</fieldset>';

        return $main = <<<HTML
        <form method="post" action="{$action}">
            <input type="hidden" name="id" value="{$this->film->getId()}" >
            <div><label>Titre :</label><input type="text" name="title" value="{$this->film->getTitle()}"></div>
            <div><label>Langue originale :</label><input name="originalLanguage" type="text" value="{$this->film->getOriginalLanguage()}" required></div>
            <div><label>Titre original :</label><input type="text" name="originalTitle" value="{$this->film->getOriginalTitle()}"  required></div>
            <div><label>Description :</label><input type="text" name="overview" value="{$this->film->getOverview()}"  required></div>
            <div><label>Date de sortie :</label><input type="date" name="releaseDate" value="{$this->film->getReleaseDate()}" ></div>
            <div><label>Temps d'écran :</label><input type="number" name="runtime" value="{$this->film->getRuntime()}" ></div>
            <div><label>Tags :</label><input type="text" name="tagline" value="{$this->film->getTagline()}" ></div>
            {$genreChoices}
            <input type="submit">
        </form>
        HTML;
    }
    public function setEntityFromQueryString():void {
        if (!isset($_POST['id'])) {
            $id = null;
        } else {
            $id = intval(StringEscaper::escapeString($_POST['id']));;
        }

        $originalLanguage = StringEscaper::escapeString($_POST['originalLanguage']);
        $originalTitle = StringEscaper::escapeString($_POST['originalTitle']);
        $overview = StringEscaper::escapeString($_POST['overview']);
        $releaseDate = StringEscaper::escapeString($_POST['releaseDate']);
        $runtime = intval(StringEscaper::escapeString($_POST['runtime']));
        $tagline = StringEscaper::escapeString($_POST['tagline']);
        $title = StringEscaper::escapeString($_POST['title']);
        $this->film = Film::create($id,$originalLanguage, $originalTitle, $overview,$releaseDate,  $runtime,  $tagline,  $title);
    }

}
