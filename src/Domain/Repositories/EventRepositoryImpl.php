<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Converters\EventConverter;
use App\Domain\Entities\Event;
use App\Utils\DateTimeUtils;
use DateTime;
use PDO;

class EventRepositoryImpl implements EventRepository
{
    private PDO $pdo;
    private EventConverter $eventConverter;
    private TagRepository $tagRepository;

    private string $eventColumns = 'id, name, start, "end"';

    public function __construct(PDO $pdo, EventConverter $eventConverter, TagRepository $tagRepository)
    {
        $this->pdo = $pdo;
        $this->eventConverter = $eventConverter;
        $this->tagRepository = $tagRepository;
    }

    public function findAll(): array
    {
        $query = $this->pdo->query("SELECT $this->eventColumns FROM events ORDER BY start");
        $events = $query->fetchAll();
        return array_map(fn($row) => $this->convertToEventWithTags($row), $events);
    }

    public function findById(int $id): ?Event
    {
        $query = $this->pdo->prepare("SELECT $this->eventColumns FROM events WHERE id = :id");
        $query->execute([$id]);
        if ($query->rowCount() == 0) {
            return null;
        }
        return $this->convertToEventWithTags($query->fetch());
    }

    public function findAllWithStartBetween(DateTime $from, ?DateTime $to): array
    {
        $query = $this->pdo->prepare(
            "SELECT $this->eventColumns FROM events WHERE start >= :start AND start < :end ORDER BY start"
        );
        $query->execute([
            'start' => DateTimeUtils::toString($from),
            'end' => $to ? DateTimeUtils::toString($to) : null]);
        $events = $query->fetchAll();
        return array_map(fn($row) => $this->convertToEventWithTags($row), $events);
    }

    public function findAllWithTagNames(array $tagNames): array
    {
        $place_holders = implode(',', array_fill(0, count($tagNames), '?'));
        $raw =
            "
            select $this->eventColumns
            from events
            where id in (select event_id
                         from events_tags
                                  join tags on tags.id = events_tags.tag_id
                         where tags.name in ($place_holders))
            ORDER BY start
            ";
        $query = $this->pdo->prepare("$raw");
        $query->execute($tagNames);
        $events = $query->fetchAll();
        return array_map(fn($row) => $this->convertToEventWithTags($row), $events);
    }

    public function create(Event $event): Event
    {
        $query = $this->pdo->prepare(
            "INSERT INTO events (name, start, \"end\") VALUES (:name, :start, :end)"
        );
        $query->execute([
            'name' => $event->getName(),
            'start' => DateTimeUtils::toString($event->getStart()),
            'end' => $event->getEnd() ? DateTimeUtils::toString($event->getEnd()) : null,
        ]);
        $eventId = (int)$this->pdo->lastInsertId('seq_events');
        foreach ($event->getTags() as $tag) {
            $this->tagRepository->create($tag, $eventId);
        }
        return $this->findById($eventId);
    }

    public function update(Event $event)
    {
        $query = $this->pdo->prepare(
            "UPDATE events SET (name, start, \"end\") = (:name, :start, :end) WHERE id = :id"
        );
        $eventId = $event->getId();
        $query->execute([
            'name' => $event->getName(),
            'start' => DateTimeUtils::toString($event->getStart()),
            'end' => DateTimeUtils::toString($event->getEnd()),
            'id' => $eventId,
        ]);

        $this->tagRepository->deleteAllByEventId($eventId);
        foreach ($event->getTags() as $tag) {
            $this->tagRepository->create($tag, $eventId);
        }
    }

    public function delete(int $eventId)
    {
        $this->pdo->beginTransaction();

        $query = $this->pdo->prepare(
            "DELETE FROM events WHERE id = :id"
        );
        $query->execute([
            'id' => $eventId,
        ]);
        $this->tagRepository->deleteAllByEventId($eventId);

        $this->pdo->commit();
    }

    private function convertToEventWithTags(array $row): Event
    {
        $event = $this->eventConverter->convert($row);
        $tags = $this->tagRepository->findAllByEventId($event->getId());
        $event->setTags($tags);
        return $event;
    }
}
