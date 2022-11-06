<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Tag;

interface TagRepository
{
    public function create(Tag $tag, int $eventId): int;

    public function findAllByEventId(int $eventId): array;
}