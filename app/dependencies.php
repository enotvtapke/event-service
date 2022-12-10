<?php

declare(strict_types=1);

use App\Controllers\EventController;
use App\Domain\Converters\EventConverter;
use App\Domain\Converters\TagConverter;
use App\Domain\Repositories\EventRepository;
use App\Domain\Repositories\EventRepositoryImpl;
use App\Domain\Repositories\TagRepository;
use App\Domain\Repositories\TagRepositoryImpl;
use App\Middleware\LoggingMiddleware;
use App\Utils\Config;
use App\Utils\ConfigImpl;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Tebru\Gson\Gson;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        Config::class => function () {
            return new ConfigImpl([
                'displayErrorDetails' => true, // TODO Should be set to false in production
                'logError' => false,
                'logErrorDetails' => false,
                'logger' => [
                    'name' => 'event-service',
                    'path' => 'php://stdout',
                    'level' => Logger::DEBUG,
                ],
                "db" => [
                    "host" => getenv('DB_HOST') ?: "localhost",
                    "port" => getenv('DB_PORT') ?: "5432",
                    "dbname" => "postgres",
                    "user" => getenv('DB_USER') ?: 'admin',
                    "password" => getenv('DB_PASSWORD') ?: 'admin'
                ]
            ]);
        },
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(Config::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        LoggingMiddleware::class => fn(ContainerInterface $c) => new LoggingMiddleware($c->get(LoggerInterface::class)),
        PDO::class => function (ContainerInterface $c) {
            $settings = $c->get(Config::class);

            $dbSettings = $settings->get('db');
            $pdo = new PDO(
                "pgsql:host=" .
                $dbSettings['host'] . ";port=" . $dbSettings['port'] . ";dbname=" . $dbSettings['dbname'],
                $dbSettings['user'],
                $dbSettings['password']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        },
        Gson::class => fn(ContainerInterface $c) => Gson::builder()->build(),
        EventConverter::class => fn() => new EventConverter(),
        TagConverter::class => fn() => new TagConverter(),
        TagRepository::class => fn(ContainerInterface $c) => new TagRepositoryImpl(
            $c->get(PDO::class),
            $c->get(TagConverter::class),
        ),
        EventRepository::class => fn(ContainerInterface $c) => new EventRepositoryImpl(
            $c->get(PDO::class),
            $c->get(EventConverter::class),
            $c->get(TagRepository::class),
        ),
        EventController::class => fn(ContainerInterface $c) => new EventController(
            $c->get(EventRepository::class),
            $c->get(Gson::class),
            $c->get(LoggerInterface::class),
        ),
    ]);
};
