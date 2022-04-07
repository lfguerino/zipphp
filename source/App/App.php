<?php

namespace LFGuerino\ZipPHP\App;

use LFGuerino\ZipPHP\Core\Controller;

class App extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../views");
    }

    public function home(): void
    {
        echo $this->render("home", []);
    }

    public function error(array $data): void
    {
        $errcode = filter_var($data['errcode'], FILTER_VALIDATE_INT);

        echo "<h1>{$errcode}</h1>";
        var_dump($data);
    }
}
