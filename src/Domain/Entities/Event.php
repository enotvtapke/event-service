<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Utils\DateUtils;
use DateTime;
use JsonSerializable;
use PhpParser\JsonDecoder;

class Event
{
    private ?int $id;

    private string $name;

    private DateTime $start;

    private ?DateTime $end;

    public function __construct(?int $id, string $name, DateTime $start, ?DateTime $end)
    {
        $this->id = $id;
        $this->name = $name;
        $this->start = $start;
        $this->end = $end;
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
}
