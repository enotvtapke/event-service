<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Tag;

interface TagRepository
{
    public function create(Tag $tag, int $eventId): int;

    /**
     * @param int $eventId
     * @return array<Tag>
     */
    public function findAllByEventId(int $eventId): array;

    public function delete(int $tagId);

    public function deleteAllByEventId(int $eventId);
}