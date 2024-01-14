<?php

namespace App\DataTransferObjects;

class CategoryDto
{
    public function __construct(
        public readonly ?string $title,
    ) {}

    public static function fromApiData(string $title): self
    {
        return new self(
            title: $title,
        );
    }
}
