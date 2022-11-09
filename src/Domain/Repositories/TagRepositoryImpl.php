<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Tag;
use App\Exceptions\ServiceException;
use PDO;

class TagRepositoryImpl implements TagRepository
{
    private PDO $pdo;
    private string $table = 'tags';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws ServiceException
     */
    public function create(Tag $tag, int $eventId): int
    {
        $this->pdo->beginTransaction();
        try {
            $tagsQuery = $this->pdo->prepare(
                "INSERT INTO $this->table (name) VALUES (:name)"
            );

            $tagsQuery->execute([$tag->getName()]);

            $tagId = (int)$this->pdo->lastInsertId('seq_tags');

            $eventsTagsQuery = $this->pdo->prepare(
                "INSERT INTO events_tags (event_id, tag_id) VALUES (:eventId, :tagId)"
            );
            $eventsTagsQuery->execute([$eventId, $tagId]) ?:
                throw new ServiceException("Error during creating relation between event $eventId and tag $tagId");
        } finally {
            $this->pdo->commit();
        }
        return $tagId;
    }

    public function findAllByEventId(int $eventId): array
    {
        $raw =
            "
            select tags.id, tags.name
                from events_tags
            join tags on tags.id = events_tags.tag_id
            where events_tags.event_id = :eventId
            ";
        $query = $this->pdo->prepare($raw);
        $query->execute([$eventId]);

        return $query->fetchAll();
    }
}