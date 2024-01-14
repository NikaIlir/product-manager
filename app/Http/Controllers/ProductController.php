<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ProductDto;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $service,
    ) {}

    public function update(UpdateProductRequest $request, string $productId): JsonResponse
    {
        try {
            $productDto = ProductDto::fromUpdateRequest($productId, $request->validated());

            $this->service->updateProduct($productDto);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }

        return response()->json(
            ['message' => 'Product updated successfully'],
            Response::HTTP_OK,
        );
    }
}
