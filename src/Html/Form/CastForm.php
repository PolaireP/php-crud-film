<?php
declare(strict_types=1);

namespace Html\Form;

use Entity\Cast;
use Entity\Collection\CastCollection;
use Entity\Collection\PeopleCollection;
use Entity\People;
use Html\Form\Html\StringEscaper;

class CastForm
{
    use StringEscaper;

    private ?Cast $cast;

    /**
     * @param Cast|null $cast
     */
    public function __construct(?Cast $cast)
    {
        $this->cast = $cast;
    }
    /**
     * @return Cast|null
     */
    public  function getCast(): ?Cast{
        return $this->cast;
    }

    public static function getHtmlForm(string $action) : string {

        $peoples = PeopleCollection::findAll();
        $actorChoice = <<<HTML
    <fieldset>
        <legend>Choix Des Acteurs</legend>
    HTML;

        foreach ($peoples as $elem) {
            $actorChoice = $actorChoice.
                <<<HTML

    <div>
        <input type="radio" name="peopleId" value="{$elem->getId()}">
        <label>{$elem->getName()}</label>
    </div>

    HTML;}
        $actorChoice = $actorChoice. '</fieldset>';

        return $main = <<<HTML
        <form method="post" action="{$action}">
            <input type="hidden" name="movieId" value="{$_GET['movieId']}" >
            <div><label>role :</label><input type="text" name="role" required></div>
            <div><label>Ordre</label><input name="order" type="number" required></div>
            {$actorChoice}
            <input type="submit">
        </form>
        HTML;
    }

    public static function getDeleteHtmlForm(string $action, int $movieId) : string {

        $casts = CastCollection::findByMovieId($movieId);
        $peoples = array();

        foreach ($casts as $elem) {
            array_push($peoples, People::findById($elem->getId()));
        }

        $actorChoice = <<<HTML
    <fieldset>
        <legend>Choix Des Acteurs</legend>
    HTML;

        foreach ($peoples as $elem) {
            $actorChoice = $actorChoice.
                <<<HTML

    <div>
        <input type="radio" name="peopleId" value="{$elem->getId()}">
        <label>{$elem->getName()}</label>
    </div>

    HTML;}
        $actorChoice = $actorChoice. '</fieldset>';

        return $main = <<<HTML
        <form method="post" action="{$action}">
            <input type="hidden" name="movieId" value="{$_GET['movieId']}" >
            <div><label>role :</label><input type="text" name="role" required></div>
            <div><label>Ordre</label><input name="order" type="number" required></div>
            {$actorChoice}
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

        $role = StringEscaper::escapeString($_POST['role']);
        $order = StringEscaper::escapeString($_POST['order']);
        $movieId = StringEscaper::escapeString($_POST['movieId']);
        $peopleId = StringEscaper::escapeString($_POST['peopleId']);
        $this->cast = Cast::create($id, intval($movieId), intval($peopleId), $role, intval($order) );
    }


}