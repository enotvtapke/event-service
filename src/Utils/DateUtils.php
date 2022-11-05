<?php

declare(strict_types=1);

namespace App\Utils;

use DateTime;

class DateUtils
{
    private static string $format = 'Y-m-d H:i:s';

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