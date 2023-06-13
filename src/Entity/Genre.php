<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;
use Entity\Exception\EntityNotFoundException;

class Genre
{
    private int $id;
    private string $name;


}