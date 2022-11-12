<?php

declare(strict_types=1);

namespace App\Domain\Converters;

use App\Domain\Entities\Event;
use App\Utils\DateTimeUtils;

class EventConverter
{
    public function convert(array $row): Event
    {
        return new Event(
            (int)$row['id'],
            $row['name'],
            DateTimeUtils::fromString($row['start']),
            $row['end'] == null ? null : DateTimeUtils::fromString($row['end']),
        );
    }
}
