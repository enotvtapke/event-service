<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Entities\Event;
use App\Domain\Repositories\EventRepository;
use App\Utils\DateTimeUtils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Tebru\Gson\Gson;

class EventController
{
    private EventRepository $eventRepository;
    private Gson $gson;
    private LoggerInterface $logger;

    public function __construct(EventRepository $eventRepository, Gson $gson, LoggerInterface $logger)
    {
        $this->eventRepository = $eventRepository;
        $this->gson = $gson;
        $this->logger = $logger;
    }

    public function findAll(Request $request, Response $response): Response
    {
        $events = $this->eventRepository->findAll();
        return $this->respondWithJson($response, $events);
    }

    public function findById(Request $request, Response $response): Response
    {
        $event = $this->eventRepository->findById((int)$request->getAttribute('id'));
        return $this->respondWithJson($response, $event);
    }

    public function findAllBetween(Request $request, Response $response): Response
    {
        $from = DateTimeUtils::fromString($request->getQueryParams()['from']);
        $to = $request->getQueryParams()['to'];
        $to = $to ? DateTimeUtils::fromString($to) : null;
        $events = $this->eventRepository->findAllWithStartBetween($from, $to);
        return $this->respondWithJson($response, $events);
    }

    public function findByTags(Request $request, Response $response): Response
    {
        $tags = $this->gson->fromJson($request->getBody()->getContents(), "array<\App\Domain\Entities\Tag>");
        $events = $this->eventRepository->findAllWithTagNames(array_map(fn($tag) => $tag->getName(), $tags));
        return $this->respondWithJson($response, $events);
    }

    public function create(Request $request, Response $response): Response
    {
        $event = $this->gson->fromJson($request->getBody()->getContents(), Event::class);
        $this->logger->info("Creating event: $event");
        if ($this->eventRepository->create($event)) {
            return $response->withStatus(200);
        } else {
            return $response->withStatus(400);
        }
    }

    private function respondWithJson(Response $response, $content): Response
    {
        $response->getBody()->write($this->gson->toJson($content));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
