<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BaseCustomException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report(): void
    {
        Log::error($this->getMessage());
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json(['error' => $this->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
