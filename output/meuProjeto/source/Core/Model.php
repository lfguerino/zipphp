<?php

namespace Source\Core;

use CoffeeCode\DataLayer\DataLayer;

class Model extends DataLayer
{

    public function __construct(string $entity, array $required)
    {
        parent::__construct($entity, $required, "id", true);
    }
}
