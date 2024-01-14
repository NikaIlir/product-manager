<?php

namespace App\Clients;

use App\Contracts\ProductApiClient;
use App\DataTransferObjects\CategoryDto;
use App\DataTransferObjects\ProductDto;
use App\Exceptions\ApiFetchException;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class FakeStoreProductApiClient implements ProductApiClient
{
    public function __construct(
        private readonly string $uri,
    ) {}

    public function products(): Collection
    {
        return $this->fetch(
            endpoint: 'products',
            dataMapper: fn(array $product) => ProductDto::fromApiData($product)
        );
    }

    public function categories(): Collection
    {
        return $this->fetch(
            endpoint: 'products/categories',
            dataMapper: fn(string $category) => CategoryDto::fromApiData($category)
        );
    }

    /**
     * @throws ApiFetchException
     */
    private function fetch(string $endpoint, callable $dataMapper): Collection
    {
        try {
            $response = Http::get($this->buildUrl($endpoint));

            if ($response->failed()) {
                throw ApiFetchException::apiRequestFailed($response->status());
            }

            $data = $response->json();

            if (!is_array($data)) {
                throw ApiFetchException::invalidResponseFormat();
            }

            return collect($data)->map($dataMapper);
        } catch (Exception $e) {
            throw ApiFetchException::unexpectedException($e);
        }
    }

    private function buildUrl(string $path): string
    {
        return "{$this->uri}/$path";
    }
}
