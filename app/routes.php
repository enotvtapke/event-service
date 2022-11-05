<?php

declare(strict_types=1);

use App\Controllers\EventController;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/api/v1', function (Group $group) {
        $group->group('/event', function (Group $group) {
            $group->get('/between', [EventController::class, 'findAllBetween']);
            $group->get('/{id}', [EventController::class, 'findById']);
            $group->get('', [EventController::class, 'findAll']);
        });
    });
};
