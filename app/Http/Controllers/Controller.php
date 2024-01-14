<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Product Documentation",
 *      description="Documentation for Product Manager",
 * )
 * @OA\SecurityScheme(
 *      type="apiKey",
 *      in="header",
 *      securityScheme="token",
 *      name="Authorization"
 *  )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
