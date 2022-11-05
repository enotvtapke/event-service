<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Event;
use App\Domain\Converters\EventConverter;
use App\Utils\DateUtils;
use DateTime;
use PDO;

class EventRepositoryImpl implements EventRepository
{
    private PDO $pdo;
    private EventConverter $eventConverter;

    private string $table = 'EVENTS';

    public function __construct(PDO $pdo, EventConverter $eventConverter)
    {
        $this->pdo = $pdo;
        $this->eventConverter = $eventConverter;
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
        return $query->rowCount() == 0 ? null : $this->eventConverter->convert($query->fetch());
    }

    public function findAllWithStartBetween(DateTime $from, DateTime $to): array
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE start >= :start AND start < :end");
        $query->execute([DateUtils::toString($from), DateUtils::toString($to)]);
        $events = $query->fetchAll();
        return array_map(fn($row) => $this->eventConverter->convert($row), $events);
    }
}
