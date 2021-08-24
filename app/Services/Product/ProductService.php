<?php


namespace App\Services\Product;


use App\Exceptions\CreateResourceException;
use App\Exceptions\DeleteResourceException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UpdateResourceException;
use App\Repositories\Product\ProductRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class ProductService extends BaseService
{
    private $oProductRepository;

    public function __construct(ProductRepository $oProductRepository)
    {
        $this->oProductRepository = $oProductRepository;
    }

    /**
     * Create a Product resource
     *
     * @param array $aProductData
     * @return mixed
     * @throws CreateResourceException
     */
    public function createProduct(array $aProductData)
    {
        try {
            return $this->oProductRepository->create($aProductData);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new CreateResourceException();
        }

    }

    /**
     * Get a paginated list of Products
     *
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function getAllProduct()
    {
        try {
            return $this->oProductRepository->paginate();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }

    }

    /**
     * Find a Product resource by its id
     *
     * @param $iId
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function findProductById($iId)
    {
        try {
            return $this->oProductRepository->find($iId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }
    }

    /**
     * Update a Product resource
     *
     * @param $iId
     * @param array $aProductData
     * @return mixed
     * @throws UpdateResourceException
     */
    public function updateProduct($iId, array $aProductData)
    {
        try {
            return $this->oProductRepository->update($aProductData, $iId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new UpdateResourceException();
        }

    }

    /**
     * Delete a Product resource
     *
     * @param $iId
     * @return int
     * @throws DeleteResourceException
     */
    public function deleteProduct($iId)
    {
        try {
            return $this->oProductRepository->delete($iId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new DeleteResourceException();
        }

    }

}
