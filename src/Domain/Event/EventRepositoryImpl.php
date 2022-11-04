<?php

namespace App\Domain\Event;

use PDO;

class EventRepositoryImpl implements EventRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM EVENTS");
        $events = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $events;
        // TODO: Implement findAll() method.
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Event
    {
        // TODO: Implement findById() method.
        return null;
    }
}