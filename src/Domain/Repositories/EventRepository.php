<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Event;
use DateTime;

interface EventRepository
{
    /**
     * @return Event[]
     */
    public function findAll(): array;

    public function findById(int $id): ?Event;

    /**
     * @return Event[]
     */
    public function findAllWithStartBetween(DateTime $from, ?DateTime $to): array;

    /**
     * @param array<string> $tagNames
     * @return array
     */
    public function findAllWithTagNames(array $tagNames): array;

    public function create(Event $event): Event;

    public function update(Event $event);

    public function delete(int $eventId);
}
