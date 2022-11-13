<?php

declare(strict_types=1);

namespace App\Domain\Converters;

use App\Domain\Entities\Tag;

class TagConverter
{
    public function convert(array $row): Tag
    {
        return new Tag(
            (int)$row['id'],
            $row['name'],
        );
    }
}
