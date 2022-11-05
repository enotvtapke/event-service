<?php

declare(strict_types=1);

namespace App\Utils;

use DateTime;
use DateTimeInterface;

class DateUtils
{
    private static string $format = DateTimeInterface::ATOM;

    public static function toString(?DateTime $dateTime): ?string
    {
        return $dateTime ? $dateTime->format(DateUtils::$format) : null;
    }

    public static function fromString(string $s): DateTime
    {
        return DateTime::createFromFormat(DateUtils::$format, $s);
    }

    public static function now(): DateTime
    {
        return new DateTime();
    }
}