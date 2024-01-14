<?php

namespace App\DataTransferObjects;

class CategoryDto
{
    public function __construct(
        public readonly ?string $title,
    ) {}

    /**
     * Create a DTO from API data
     *
     * @param array $data Data from the API
     * @return self
     */
    public static function fromApiData(array $data): self
    {
        return new self(
            title: $data['title'],
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
        ];
    }
}
