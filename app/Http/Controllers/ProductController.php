<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ProductDto;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $service,
    ) {}

    /**
     * Update Product by ID
     * @OA\Put (
     *      path="/api/products/{product}",
     *      tags={"Product"},
     *      security={
     *          {"token": {}}
     *      },
     *      @OA\Parameter(
     *          description="Product ID",
     *          in="path",
     *          name="product",
     *          required=true,
     *          example="1",
     *          @OA\Schema(type="integer", format="int64")
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="title", type="string"),
     *                      @OA\Property(property="description", type="string")
     *                 ),
     *                 example={
     *                     "title": "Product Title",
     *                     "description": "Product Description",
     *                     "image": "https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg",
     *                     "price": 10.99,
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Product updated successfully!"),
     *          )
     *      ),
     *     @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Unauthenticated."),
     *           )
     *      ),
     * )
     */
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
            ['message' => 'Product updated successfully!'],
            Response::HTTP_OK,
        );
    }
}
