<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($container) {
        $renderer = new \Slim\Views\Twig(__DIR__.'/../templates', [
            'cache' => false,
            'debug' => true,
        ]);
        $renderer->addExtension(new \Slim\Views\TwigExtension(
            $container->router,
            $container->request->getUri()
        ));
        $renderer->addExtension(new \Twig\Extension\DebugExtension());

        return $renderer;
    };

    // Controllers, ading every controllers to container is probably not the best solution (?)
    $container['HomeController'] = function($container) {
        return new \App\Controllers\HomeController($container->get('renderer'));
    };
    $container['ErrorController'] = function($container) {
        return new \App\Controllers\ErrorController($container->get('renderer'));
    };

    $container['APIController'] = function($container) {
        return new \App\Controllers\APIController($container->get('settings')['customs']['API']);
    };

    //Errors
    $container['notFoundHandler'] = function ($container) {
        return function($request, $response) use ($container) {
            return $container->get('renderer')->render($response, 'error.twig',
            [
                'error' => 404,
                'message' => "Pas trouvé."
            ]);
        };
    };
    $container['notAllowedHandler'] = function ($container) {
        return function($request, $response) use ($container) {
            return $container->get('renderer')->render($response, 'error.twig',
            [
                'error' => 405,
                'message' => "Pas autorisé."
            ]);
        };
    };
};