<?php

define('ROOT', realpath(__DIR__ . '/../app'));

use DI\Container;
use Middlewares\TrailingSlash;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require ROOT . '/vendor/autoload.php';

// Create Container using PHP-DI
$container = new Container();
AppFactory::setContainer($container);
$container->set('view', function () {
    return new Twig(ROOT . '/view');
});

$container->set('config', function () {
    require_once realpath(ROOT . '/configs/config.php');
    return $data;
});

// Set container to create App with on AppFactory
$app = AppFactory::create();

$app->addRoutingMiddleware();

// Add Twig-View Middleware
$app->add(TwigMiddleware::createFromContainer($app));

// Add trailing slash
$app->add(new TrailingSlash());

// Add two routes
$app->get('/', \Ithomeironman2019\Controller\HomeController::class . ':index');
$app->get('/about', \Ithomeironman2019\Controller\HomeController::class . ':about');

// Run application
$app->run();