<?php

use Slim\App;

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);
    $container = $app->getContainer();

    $container['Middleware'] = function($container) {
        return new \App\Middlewares\Middleware($container->get('settings')['customs']['key']);
    };
};
