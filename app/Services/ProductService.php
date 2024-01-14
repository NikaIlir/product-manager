<?php

namespace App\Services;

use App\DataTransferObjects\ProductDto;
use App\Exceptions\ProductImportException;
use App\Models\Product;
use Exception;
use Illuminate\Support\Collection;

class ProductService
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {}

    /**
     * @param Collection<ProductDto> $products
     * @throws ProductImportException
     */
    public function importProducts(Collection $products): void
    {
        foreach ($products as $product) {
            $this->importOrUpdateProduct($product);
        }
    }

    /**
     * @throws ProductImportException
     */
    protected function importOrUpdateProduct(ProductDto $productDto): void
    {
        try {
            $categoryId = $this->categoryService->getCategoryIdByTitle($productDto->category);

            Product::query()->updateOrCreate(
                ['external_id' => $productDto->id],
                array_merge(
                    $productDto->toArray(),
                    ['category_id' => $categoryId]
                )
            );
        } catch (Exception $e) {
            throw ProductImportException::unknownError($e);
        }
    }

    public function updateProduct(ProductDto $productDto): void
    {
        $product = Product::query()->findOrFail($productDto->id);

        $updateData = array_filter(
            $productDto->toArray(),
            static fn ($value) => !is_null($value)
        );

        $product->update($updateData);
    }
}
