<?php

namespace App\Http\Controllers\Product;

use App\Constants\Product\ProductConstants;
use App\Exceptions\CreateResourceException;
use App\Exceptions\DeleteResourceException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UpdateResourceException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\Create\ProductCreateRequest;
use App\Http\Requests\Product\Update\ProductUpdateRequest;
use App\Services\Product\ProductService;
use App\Traits\ResponseTrait;
use App\Transformers\ProductTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProductController extends BaseController
{
    use ResponseTrait;

    private $oProductService;

    public function __construct(ProductService $oProductService)
    {
        $this->oProductService = $oProductService;
    }

    /**
     * Get paginated list of products
     *
     * @return array
     * @throws ResourceNotFoundException
     */
    public function index()
    {
        $oProductData = $this->oProductService->getAllProduct();

        return $this->transform($oProductData, ProductTransformer::class);
    }

    /**
     * Find a product by its id
     *
     * @param $iId
     * @return array
     * @throws ValidationException
     * @throws ResourceNotFoundException
     */
    public function show($iId)
    {
        $this->validate(request()->merge(['id' => $iId]), ProductConstants::REQUIRED_PRODUCT_ID_VALIDATION_RULE);

        $oProductData = $this->oProductService->findProductById($iId);

        return $this->transform($oProductData, ProductTransformer::class);
    }

    /**
     * Create and save new Product
     *
     * @param ProductCreateRequest $oRequest
     * @return array
     * @throws ResourceNotFoundException
     * @throws CreateResourceException
     */
    public function store(ProductCreateRequest $oRequest)
    {
        $aData = $oRequest->all();

        $oProductData = $this->oProductService->createProduct($aData);

        return $this->transform($oProductData, ProductTransformer::class);
    }


    /**
     * Update Product data by its ID
     *
     * @param ProductUpdateRequest $oRequest
     * @param $iId
     * @return array
     * @throws ValidationException
     * @throws ResourceNotFoundException
     * @throws UpdateResourceException+
     */
    public function update(ProductUpdateRequest $oRequest, $iId)
    {
        $this->validate($oRequest->merge(['id' => $iId]), ProductConstants::REQUIRED_PRODUCT_ID_VALIDATION_RULE);

        $aData = $oRequest->only(ProductConstants::UPDATE_PRODUCT_PARAMS);

        $oProductData = $this->oProductService->updateProduct($iId, $aData);

        return $this->transform($oProductData, ProductTransformer::class);
    }


    /**
     * Delete a Product
     *
     * @param $iId
     * @return JsonResponse
     * @throws ValidationException
     * @throws DeleteResourceException
     */
    public function destroy($iId)
    {
        $this->validate(request()->merge(['id' => $iId]), ProductConstants::REQUIRED_PRODUCT_ID_VALIDATION_RULE);

        $iProductsDeleted = $this->oProductService->deleteProduct($iId);

        return $this->json([
            'code' => Response::HTTP_OK,
            'products_deleted' => $iProductsDeleted
        ]);
    }
}
