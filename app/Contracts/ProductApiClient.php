<?php

namespace App\Contracts;

use App\DataTransferObjects\CategoryDto;
use App\DataTransferObjects\ProductDto;
use App\Exceptions\ApiFetchException;
use Illuminate\Support\Collection;

interface ProductApiClient
{
    /**
     * Fetches products from an external API.
     *
     * @return Collection<ProductDto> The list of products.
     * @throws ApiFetchException If there is an error during fetching.
     */
    public function products(): Collection;

    /**
     * Fetches categories from an external API.
     *
     * @return Collection<CategoryDto> The list of categories.
     * @throws ApiFetchException If there is an error during fetching.
     */
    public function categories(): Collection;
}
