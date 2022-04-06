<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 *
 */
class Task extends DataLayer
{

    public function __construct()
    {
        parent::__construct("tasks", ["title", "status"], "id", true);
    }

    /**
     * @param string $title
     * @param string|null $description
     * @param string $status
     * @return $this
     */
    public function bootstrap(
        string $title,
        ?string $description = null,
        string $status = "Not Schedule"
    ): Task {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;

        return $this;
    }
}
