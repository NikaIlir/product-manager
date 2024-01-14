<?php

namespace App\Console\Commands;

use App\Contracts\ProductApiClient;
use App\DataTransferObjects\ProductDto;
use App\Exceptions\ApiFetchException;
use App\Exceptions\ProductImportException;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CMD;

class ImportProducts extends Command
{
    protected $signature = 'app:import-products';

    protected $description = 'Imports products from the Fake Store API';

    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly ProductService $productService,
        private readonly ProductApiClient $client,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('Starting product import...');

        try {
            $categories = $this->client->categories();
            $this->categoryService->importCategories($categories);

            $products = $this->client->products();

            $this->productService->importProducts($products, $categories);

            $this->info('Product import completed successfully.');
        } catch (ApiFetchException|ProductImportException $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            return CMD::FAILURE;
        }

        return CMD::SUCCESS;
    }
}
