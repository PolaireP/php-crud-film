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




}