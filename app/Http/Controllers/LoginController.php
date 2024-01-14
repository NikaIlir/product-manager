<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UserDto;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class LoginController extends Controller
{
    public function __construct(
        private readonly UserService $service,
    ) {}

    /**
     * Get User Token
     * @OA\Post (
     *     path="/api/sanctum/token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="password", type="string")
     *                 ),
     *                 example={
     *                     "email":"test@example.com",
     *                     "password":"password"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="1|randomtokenasfhajskfhajf398rureuuhfdshk"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The password field is required."),
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="password", type="array", collectionFormat="multi",
     *                      @OA\Items(type="string", example="The password field is required.")
     *                  ),
     *              ),
     *          )
     *      )
     * )
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $userToken = $this->service->generateUserToken(
            userDto: UserDto::fromRequest($request->validated())
        );

        return response()->json([
            'token' => $userToken,
        ]);
    }
}
