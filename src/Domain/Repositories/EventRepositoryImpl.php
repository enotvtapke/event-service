<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Converters\EventConverter;
use App\Domain\Entities\Event;
use App\Utils\DateUtils;
use DateTime;
use PDO;

class EventRepositoryImpl implements EventRepository
{
    private PDO $pdo;
    private EventConverter $eventConverter;
    private TagRepository $tagRepository;

    private string $table = 'EVENTS';

    public function __construct(PDO $pdo, EventConverter $eventConverter, TagRepository $tagRepository)
    {
        $this->pdo = $pdo;
        $this->eventConverter = $eventConverter;
        $this->tagRepository = $tagRepository;
    }

    public function findAll(): array
    {
        $query = $this->pdo->query("SELECT * FROM $this->table");
        $events = $query->fetchAll();
        return array_map(fn($row) => $this->eventConverter->convert($row), $events);
    }

    public function findById(int $id): ?Event
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE id = :id");
        $query->execute([$id]);
        if ($query->rowCount() == 0) {
            return null;
        }
        $event = $this->eventConverter->convert($query->fetch());
        $tags = $this->tagRepository->findAllByEventId($id);
        $event->setTags($tags);
        return $event;
    }

    public function findAllWithStartBetween(DateTime $from, DateTime $to): array
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE start >= :start AND start < :end");
        $query->execute([DateUtils::toString($from), DateUtils::toString($to)]);
        $events = $query->fetchAll();
        return array_map(fn($row) => $this->eventConverter->convert($row), $events);
    }

    public function create(Event $event): int
    {
        $query = $this->pdo->prepare(
            "INSERT INTO $this->table (id, name, start, \"end\") VALUES (nextval('seq_events'), :name, :start, :end)"
        );
        $query->execute([
            $event->getName(),
            DateUtils::toString($event->getStart()),
            DateUtils::toString($event->getEnd()),
        ]);
        $eventId = (int)$this->pdo->lastInsertId('seq_events');
        foreach ($event->getTags() as $tag) {
            $this->tagRepository->create($tag, $eventId);
        }
        return $eventId;
    }
}
