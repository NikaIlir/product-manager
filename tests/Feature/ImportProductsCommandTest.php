<?php
namespace Tests\Feature;

use App\Contracts\ProductApiClient;
use App\DataTransferObjects\CategoryDto;
use App\DataTransferObjects\ProductDto;
use App\Exceptions\ApiFetchException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command;
use Tests\TestCase;

class ImportProductsCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_products_successfully(): void
    {
        $mockedCategories = $this->createMockedCategories();
        $mockedProducts = $this->createMockedProducts();

        $this->mockProductApiClient($mockedCategories, $mockedProducts);

        $output = Artisan::call('app:import-products');

        $this->assertEquals(Command::SUCCESS, $output);
        $this->assertDatabaseHas('products', ['title' => 'Test Product 1']);
        $this->assertDatabaseHas('categories', ['title' => 'Category 1']);
    }

    /** @test */
    public function it_handles_api_fetch_exception(): void
    {
        $this->mock(ProductApiClient::class, function ($mock) {
            $mock->shouldReceive('categories')
                ->once()
                ->andThrow(new ApiFetchException('API Error'));
        });

        $output = Artisan::call('app:import-products');

        $this->assertEquals(Command::FAILURE, $output);
    }

    private function createMockedCategories(): Collection
    {
        return collect(['Category 1'])->map(fn ($item) => CategoryDto::fromApiData($item));
    }

    private function createMockedProducts(): Collection
    {
        return collect([
            [
                'id' => 1,
                'title' => 'Test Product 1',
                'description' => 'Test Product 1 Description',
                'category' => 'Category 1',
                'image' => 'https://via.placeholder.com/600/92c952',
                'price' => 10.0,
                'rating' => [
                    'rate' => 4.5,
                    'count' => 10,
                ],
            ],
        ])->map(fn ($item) => ProductDto::fromApiData($item));
    }

    private function mockProductApiClient(Collection $mockedCategories, Collection $mockedProducts): void
    {
        $this->mock(ProductApiClient::class, function ($mock) use ($mockedCategories, $mockedProducts) {
            $mock->shouldReceive('categories')
                ->once()
                ->andReturn($mockedCategories);

            $mock->shouldReceive('products')
                ->once()
                ->andReturn($mockedProducts);
        });
    }
}
