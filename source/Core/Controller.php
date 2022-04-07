<?php

namespace LFGuerino\ZipPHP\Core;

class Controller
{
    private $engine;

    public function __construct(string $pathToViews = 'views', string $ext = 'php')
    {
        $this->engine = \League\Plates\Engine::create($pathToViews, $ext);
    }

    public function engine(): \League\Plates\Engine
    {
        return $this->engine;
    }

    public function render(string $template, array $data): string
    {
        return $this->engine->render($template, $data);
    }
}
