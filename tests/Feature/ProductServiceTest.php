<?php
namespace Tests\Feature;

use App\DataTransferObjects\ProductDto;
use App\Exceptions\ProductImportException;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var ProductService */
    private ProductService $productService;

    /** @var CategoryService */
    private CategoryService $categoryService;

    public function setUp(): void
    {
        parent::setUp();

        Category::factory()->create([
            'title' => 'Category 1',
        ]);

        $this->productService = $this->app->make(ProductService::class);
        $this->categoryService = $this->app->make(CategoryService::class);
    }

    /** @test
     * @throws ProductImportException
     */
    public function it_imports_products_successfully(): void
    {
        $mockProduct = $this->createMockProduct(category: 'Category 1');

        $this->mockCategoryService();

        $this->productService->importProducts(collect([$mockProduct]));

        $this->assertDatabaseHas('products', ['title' => $mockProduct->title]);
    }

    /** @test */
    public function it_handles_product_import_exception(): void
    {
        $this->mock(CategoryService::class, function ($mock) {
            $mock->shouldReceive('getCategoryIdByTitle')->andReturn(1);
        });

        $invalidProduct = $this->createMockProduct(category: 'Category 2');

        $this->expectException(ProductImportException::class);

        $this->productService->importProducts(new Collection([$invalidProduct]));
    }

    private function createMockProduct($category): ProductDto
    {
        return ProductDto::fromApiData([
            'id' => 1,
            'title' => 'Test Product 1',
            'description' => 'Test Product 1 Description',
            'category' => $category,
            'image' => 'https://via.placeholder.com/600/92c952',
            'price' => 10.0,
            'rating' => [
                'rate' => 4.5,
                'count' => 10,
            ],
        ]);
    }

    private function mockCategoryService(): void
    {
        $this->mock(CategoryService::class, function ($mock) {
            $mock->shouldReceive('getCategoryIdByTitle')->with('Category 1')->andReturn(1);
        });
    }
}
