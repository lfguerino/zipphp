<?php

ob_start();

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(URL_BASE_TEST);

$router->namespace("LFGuerino\ZipPHP\App");

################
##   ROUTES   ##
################
$router->group(null);
$router->get("/", "App:home");


###############
##   ERROR   ##
###############
$router->group("error");
$router->get("/{errcode}", "App:error");


##################
##   DISPATCH   ##
##################
$router->dispatch();

if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}

ob_end_flush();
