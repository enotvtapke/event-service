<?php

namespace App\Domain\Repositories;

use App\Domain\Converters\TagConverter;
use App\Domain\Entities\Tag;
use PDO;

class TagRepositoryImpl implements TagRepository
{
    private PDO $pdo;
    private TagConverter $tagConverter;

    public function __construct(PDO $pdo, TagConverter $tagConverter)
    {
        $this->pdo = $pdo;
        $this->tagConverter = $tagConverter;
    }

    public function create(Tag $tag, int $eventId): int
    {
        $this->pdo->beginTransaction();

        $tagsQuery = $this->pdo->prepare(
            "INSERT INTO tags (name) VALUES (:name)"
        );
        $tagsQuery->execute([$tag->getName()]);

        $tagId = (int)$this->pdo->lastInsertId('seq_tags');
        $eventsTagsQuery = $this->pdo->prepare(
            "INSERT INTO events_tags (event_id, tag_id) VALUES (:eventId, :tagId)"
        );
        $eventsTagsQuery->execute([$eventId, $tagId]);

        $this->pdo->commit();
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

        $tags = $query->fetchAll();
        return array_map(fn($tag) => $this->tagConverter->convert($tag), $tags);
    }

    public function delete(int $tagId)
    {
        $query = $this->pdo->prepare("DELETE FROM tags WHERE id = :id");
        $query->execute([
            'id' => $tagId
        ]);
    }

    public function deleteAllByEventId(int $eventId)
    {
        $tags = $this->findAllByEventId($eventId);
        foreach ($tags as $tag) {
            $this->delete($tag->getId());
        }
    }
}