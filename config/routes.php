<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', 'HomeController')->setName('home');

    $app->post('/music', 'APIController:addMusic')->add('Middleware');
};
