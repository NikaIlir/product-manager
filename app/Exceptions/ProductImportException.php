<?php

namespace App\Exceptions;

use Throwable;

class ProductImportException extends BaseCustomException
{
    public static function unknownError(Throwable $e): self
    {
        return new self('Failed to import/update product: ' . $e->getMessage(), 0, $e);
    }
}
