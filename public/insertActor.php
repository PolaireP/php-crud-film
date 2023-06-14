<?php
declare(strict_types=1);

use Entity\Cast;
use Html\Form\CastForm;

$form = new CastForm(null);
$form->setEntityFromQueryString();
var_dump($form);
$form->getCast()->save();
