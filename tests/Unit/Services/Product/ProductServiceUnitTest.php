<?php

namespace Tests\Services\Product;

use App\Exceptions\CreateResourceException;
use App\Exceptions\DeleteResourceException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UpdateResourceException;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\Unit\BaseUnitTest;

class ProductServiceUnitTest extends BaseUnitTest
{

    public function test__construct()
    {
        $oProductRepository = $this->createMock(ProductRepository::class);
        $oProductService = new ProductService($oProductRepository);

        $this->assertInstanceOf(ProductService::class, $oProductService);
    }

    /**
     * @throws CreateResourceException
     * @throws BindingResolutionException
     */
    public function testCreateProduct()
    {
        $oProductRepository = $this->app->make(ProductRepository::class);
        $oProductService = new ProductService($oProductRepository);

        //test successful create
        $oCreatedData = $oProductService->createProduct(self::EXAMPLE_PRODUCT_DATA);
        $this->assertInstanceOf(Product::class, $oCreatedData);

        //test exception throw
        $this->expectException(CreateResourceException::class);
        $oProductService->createProduct([]);
    }

    /**
     * @throws BindingResolutionException
     * @throws ResourceNotFoundException
     * @throws CreateResourceException
     */
    public function testFindProductById()
    {
        $oProductRepository = $this->app->make(ProductRepository::class);
        $oProductService = new ProductService($oProductRepository);

        $oCreatedData = $oProductService->createProduct(self::EXAMPLE_PRODUCT_DATA);
        $this->assertInstanceOf(Product::class, $oCreatedData);

        //test successful get
        $oFetchedProductData = $oProductService->findProductById($oCreatedData->id);
        $this->assertInstanceOf(Product::class, $oFetchedProductData);

        //test exception throw
        $this->expectException(ResourceNotFoundException::class);
        $oProductService->findProductById(0);

    }

    /**
     * @throws BindingResolutionException
     * @throws ResourceNotFoundException
     * @throws CreateResourceException
     */
    public function testGetAllProduct()
    {
        $oProductRepository = $this->app->make(ProductRepository::class);
        $oProductService = new ProductService($oProductRepository);
        $oProductService->createProduct(self::EXAMPLE_PRODUCT_DATA);

        $oProductsData = $oProductService->getAllProduct();

        $this->assertInstanceOf(LengthAwarePaginator::class, $oProductsData);
    }

    /**
     * @throws BindingResolutionException
     * @throws UpdateResourceException
     * @throws CreateResourceException
     */
    public function testUpdateProduct()
    {
        $oProductRepository = $this->app->make(ProductRepository::class);
        $oProductService = new ProductService($oProductRepository);

        $oCreatedData = $oProductService->createProduct(self::EXAMPLE_PRODUCT_DATA);
        $this->assertInstanceOf(Product::class, $oCreatedData);


        // test successful update
        $oUpdatedData = $oProductService->updateProduct($oCreatedData->id, self::EXAMPLE_PRODUCT_DATA);
        $this->assertInstanceOf(Product::class, $oUpdatedData);

        // test exception throw
        $this->expectException(UpdateResourceException::class);
        $oProductService->updateProduct(0, self::EXAMPLE_PRODUCT_DATA);
    }

    /**
     * @throws BindingResolutionException
     * @throws DeleteResourceException
     * @throws CreateResourceException
     */
    public function testDeleteProduct()
    {
        $oProductRepository = $this->app->make(ProductRepository::class);
        $oProductService = new ProductService($oProductRepository);

        $oCreatedData = $oProductService->createProduct(self::EXAMPLE_PRODUCT_DATA);
        $this->assertInstanceOf(Product::class, $oCreatedData);

        // test successful update
        $bDeleteResponse = $oProductService->deleteProduct($oCreatedData->id);
        $this->assertEquals(true, $bDeleteResponse);

        // test exception throw
        $this->expectException(DeleteResourceException::class);
        $oProductService->deleteProduct(0);
    }

}
