<?php

declare(strict_types=1);

namespace App\Domain\Converters;

use App\Domain\Entities\Event;
use DateTime;

class EventConverter
{
    public function convert(array $row): Event
    {
        return new Event(
            (int) $row['id'],
            $row['name'],
            new DateTime($row['start']),
            $row['end'] == null ? null : new DateTime($row['end']),
        );
    }
}
