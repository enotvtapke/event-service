<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Repositories\EventRepository;
use App\Utils\DateUtils;
use DateInterval;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EventController
{
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function findAll(Request $request, Response $response): Response
    {
        $events = $this->eventRepository->findAllWithStartBetween(
            (new DateTime())->sub(new DateInterval('P1D')),
            new DateTime()
        );
        return $this->respondWithJson($response, $events);
    }

    public function findById(Request $request, Response $response): Response
    {
        $event = $this->eventRepository->findById((int) $request->getAttribute('id'));
        return $this->respondWithJson($response, $event);
    }

    public function findAllBetween(Request $request, Response $response): Response
    {
        $from = $request->getQueryParams()['from'];
        $to = $request->getQueryParams()['to'];
        $events = $this->eventRepository->findAllWithStartBetween(
            DateUtils::fromString($from),
            DateUtils::fromString($to),
        );
        return $this->respondWithJson($response, $events);
    }

    private function respondWithJson(Response $response, $content): Response
    {
        $response->getBody()->write(json_encode($content, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    }
}