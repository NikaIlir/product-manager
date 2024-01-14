<?php

namespace App\Services;

use App\DataTransferObjects\CategoryDto;
use App\Exceptions\ProductImportException;
use App\Models\Category;
use Exception;
use Illuminate\Support\Collection;

class CategoryService
{
    /**
     * @param Collection<CategoryDto> $categories
     * @throws ProductImportException
     */
    public function importCategories(Collection $categories): void
    {
        foreach ($categories as $category) {
            $this->importCategory($category);
        }
    }

    /**
     * @param CategoryDto $categoryDto
     * @return void
     * @throws ProductImportException
     */
    protected function importCategory(CategoryDto $categoryDto): void
    {
        try {
            Category::query()->firstOrCreate(
                ['title' => $categoryDto->title],
            );
        } catch (Exception $e) {
            throw ProductImportException::unknownError();
        }
    }

    public function getCategoryIdByTitle(string $title): int
    {
        return Category::query()->where('title', $title)->firstOrFail()->id;
    }
}
