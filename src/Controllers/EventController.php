<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Event\EventRepository;

class EventController
{
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function findAll($request, $response)
    {
        $response->getBody()->write(json_encode($this->eventRepository->findAll(), JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    }
}