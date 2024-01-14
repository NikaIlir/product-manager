<?php

namespace App\DataTransferObjects;

class CategoryDto
{
    public function __construct(
        public readonly ?string $title,
    ) {}

    public static function fromApiData(array $data): self
    {
        return new self(
            title: $data['title'],
        );
    }
}
