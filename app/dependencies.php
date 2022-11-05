<?php

declare(strict_types=1);

use App\Controllers\EventController;
use App\Domain\Converters\EventConverter;
use App\Domain\Repositories\EventRepository;
use App\Domain\Repositories\EventRepositoryImpl;
use App\Utils\Config;
use App\Utils\ConfigImpl;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        Config::class => function () {
            return new ConfigImpl([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError' => false,
                'logErrorDetails' => false,
                'logger' => [
                    'name' => 'event-service',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                "db" => [
                    "host" => "localhost",
                    "port" => "5432",
                    "dbname" => "postgres",
                    "user" => $_ENV['db.user'] ?? 'admin',
                    "password" => $_ENV['db.password'] ?? 'admin'
                ],
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
        EventConverter::class => fn() => new EventConverter(),
        EventRepository::class => fn(ContainerInterface $c) => new EventRepositoryImpl(
            $c->get(PDO::class),
            $c->get(EventConverter::class),
        ),
        EventController::class => fn(ContainerInterface $c) => new EventController($c->get(EventRepository::class)),
    ]);
};
