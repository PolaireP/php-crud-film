<?php

declare(strict_types=1);

use Entity\People;

$personne = People::findById(5);
var_dump($personne);
