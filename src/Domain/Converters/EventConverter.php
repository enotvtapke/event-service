<?php

declare(strict_types=1);

namespace App\Domain\Converters;

use App\Domain\Entities\Event;
use App\Domain\Entities\Tag;
use App\Utils\DateTimeUtils;

class EventConverter
{
    /**
     * @param array $row
     * @param array<Tag> $tags
     * @return Event
     */
    public function convert(array $row, array $tags = []): Event
    {
        $event = new Event(
            (int)$row['id'],
            $row['name'],
            DateTimeUtils::fromString($row['start']),
            $row['end'] == null ? null : DateTimeUtils::fromString($row['end']),
        );
        $event->setTags($tags);
        return $event;
    }
}
