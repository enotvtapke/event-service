<?php

declare(strict_types=1);

use App\Middleware\LoggingMiddleware;
use App\Utils\Config;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);

if (false) { // TODO Remove if
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$settings = $container->get(Config::class);

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

$app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$app->add(LoggingMiddleware::class);

$app->run();
