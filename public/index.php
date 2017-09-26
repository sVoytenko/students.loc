<?php
//test
require '../app/autoload.php';
$router = new Router();
$controller = $router->getController();
$controller->run($router->action);