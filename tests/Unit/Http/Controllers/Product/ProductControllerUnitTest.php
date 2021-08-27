<?php

namespace Tests\Unit\Http\Controllers\Product;

use App\Exceptions\CreateResourceException;
use App\Exceptions\DeleteResourceException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UpdateResourceException;
use App\Http\Controllers\Product\ProductController;
use App\Http\Requests\Product\Create\ProductCreateRequest;
use App\Http\Requests\Product\Update\ProductUpdateRequest;
use App\Services\Product\ProductService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\TestCase;
use Tests\Unit\BaseUnitTest;

class ProductControllerUnitTest extends BaseUnitTest
{
    public function test__construct()
    {
        $oProductService = $this->createMock(ProductService::class);
        $oProductController = new ProductController($oProductService);

        $this->assertInstanceOf(ProductController::class, $oProductController);
    }

    /**
     * @throws ResourceNotFoundException
     * @throws BindingResolutionException
     */
    public function testIndex()
    {
        $this->seed();
        $oProductService = $this->app->make(ProductService::class);
        $oProductController = new ProductController($oProductService);

        $aResponseData = $oProductController->index();

        $this->assertNotEmpty($aResponseData);
    }

    /**
     * @throws ResourceNotFoundException
     * @throws ValidationException
     * @throws BindingResolutionException
     */
    public function testShow()
    {
        $oProductService = $this->app->make(ProductService::class);
        $oProductController = new ProductController($oProductService);

        $oCreatedData = $oProductService->createProduct(self::EXAMPLE_PRODUCT_DATA);
        $aResponseData = $oProductController->show($oCreatedData->id);

        $this->assertNotEmpty($aResponseData);
    }

    /**
     * @throws BindingResolutionException
     * @throws CreateResourceException
     * @throws ResourceNotFoundException
     */
    public function testStore()
    {
        $oProductService = $this->app->make(ProductService::class);
        $oProductController = new ProductController($oProductService);

        $oProductCreateRequest = new ProductCreateRequest(self::EXAMPLE_PRODUCT_DATA);

        $aCreatedData = $oProductController->store($oProductCreateRequest);
        $this->assertNotEmpty($aCreatedData);
    }

    /**
     * @throws BindingResolutionException
     * @throws ResourceNotFoundException
     * @throws ValidationException
     * @throws UpdateResourceException
     */
    public function testUpdate()
    {
        $aUpdateData = [
            'name' => 'Example Name Updated'
        ];

        $oProductService = $this->app->make(ProductService::class);
        $oProductController = new ProductController($oProductService);
        $oProductUpdateRequest = new ProductUpdateRequest($aUpdateData);

        $oCreatedData = $oProductService->createProduct(self::EXAMPLE_PRODUCT_DATA);

        $aUpdatedProductData = $oProductController->update($oProductUpdateRequest, $oCreatedData->id);

        $this->assertNotEmpty($aUpdatedProductData);
    }

    /**
     * @throws BindingResolutionException
     * @throws ValidationException
     * @throws DeleteResourceException
     */
    public function testDestroy()
    {
        $oProductService = $this->app->make(ProductService::class);
        $oProductController = new ProductController($oProductService);
        $oCreatedData = $oProductService->createProduct(self::EXAMPLE_PRODUCT_DATA);

        $oDeleteResponse = $oProductController->destroy($oCreatedData->id);
        $aDeleteResponse = json_decode($oDeleteResponse->getContent(), true);

        $this->assertEquals(true, $aDeleteResponse['is_product_deleted']);
    }

}
