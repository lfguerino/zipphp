<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";


use CoffeeCode\Router\Router;

$router = new Router(url(), ":");


$router->namespace("Source\App");
$router->group(null);
$router->get("/", "TaskController:home", "task.home");
$router->post("/tarefa/adicionar", "TaskController:add", "task.add");
$router->get("/tarefa/completar/{id}", "TaskController:complete", "task.complete");
$router->get("/tarefa/desfazer/{id}", "TaskController:undo", "task.undo");
$router->get("/tarefa/remover/{id}", "TaskController:remove", "task.remove");
$router->get("/tarefa/remover/todas", "TaskController:clear","task.clear");



/**
 * ERROR ROUTES
 */
$router->group("/ops");
$router->get("/{errcode}", "TaskController:error");


/**
 * DISPATCH
 */
$router->dispatch();

/**
 * ERROR REDIRECT
 */
if ($router->error()) {
    $router->redirect("/ops/{$router->error()}");
}

ob_end_flush();
