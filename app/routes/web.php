<?php

global $router;

use App\Controllers\HomeController;

$router->get('/', [HomeController::class, 'index'])->setName('home');
