<?php

declare(strict_types=1);

namespace App\Domain\Event;

use DateTime;
use JsonSerializable;

class Event implements JsonSerializable
{
    private ?int $id;

    private string $name;

    private DateTime $start;

    private ?DateTime $end;

    public function __construct(?int $id, string $name, DateTime $start, ?DateTime $end)
    {
        $this->id = $id;
        $this->name = $name;
        $this->$start = $start;
        $this->$end = $end;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStart(): DateTime
    {
        return $this->start;
    }

    public function getEnd(): ?DateTime
    {
        return $this->end;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start' => $this->start,
            'end' => $this->end,
        ];
    }
}
