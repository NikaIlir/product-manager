<?php

namespace App\DataTransferObjects;

class ProductDto
{
    public function __construct(
        public readonly int $id,
        public readonly ?int $categoryId,
        public readonly ?string $title,
        public readonly ?float $price,
        public readonly ?string $description,
        public readonly ?string $category,
        public readonly ?string $image,
        public readonly ?float $ratingRate,
        public readonly ?int $ratingCount
    ) {}

    public static function fromApiData(array $data, int $categoryId = null): self
    {
        return new self(
            id: $data['id'],
            categoryId: $categoryId,
            title: $data['title'],
            price: $data['price'],
            description: $data['description'],
            category: $data['category'],
            image: $data['image'],
            ratingRate: $data['rating']['rate'],
            ratingCount: $data['rating']['count']
        );
    }

    public static function fromUpdateRequest(int $id, array $data): self
    {
        return new self(
            id: $id,
            categoryId: null,
            title: $data['title'] ?? null,
            price: $data['price'] ?? null,
            description: $data['description'] ?? null,
            category: null,
            image: $data['image'] ?? null,
            ratingRate: null,
            ratingCount: null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->categoryId,
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $this->image,
            'rating_rate' => $this->ratingRate,
            'rating_count' => $this->ratingCount,
        ];
    }
}
