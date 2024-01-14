<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UserDto;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(
        private readonly UserService $service,
    ) {}

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
