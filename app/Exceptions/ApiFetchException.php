<?php

namespace App\Exceptions;

use Throwable;

class ApiFetchException extends BaseCustomException
{
    public static function unexpectedException(Throwable $e): self
    {
        return new self('Unexpected error while fetching products: ' . $e->getMessage(), 0, $e);
    }

    public static function invalidResponseFormat(): self
    {
        return new self('Invalid response format from FakeStoreProduct API');
    }

    public static function productNotFound(): self
    {
        return new self('Product not found in FakeStoreProduct API');
    }

    public static function apiRequestFailed(int $statusCode): self
    {
        return new self('API request failed with status code: ' . $statusCode);
    }
}
