<?php

declare(strict_types=1);

use App\Controllers\EventController;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/events', function (Group $group) {
        $group->get('', [EventController::class, 'findAll']);
    });
};
