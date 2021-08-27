<?php


namespace Tests\Feature\Product\Delete;


use Tests\Feature\BaseFeatureTest;

class ProductDeleteFeatureTest extends BaseFeatureTest
{

    public function testDeleteProduct()
    {
        $aCreatedProductData = $this->createExampleProduct();

        $oDeletedProductResponse = $this->deleteJson(self::PRODUCTS_BASE_ROUTE . '/' . $aCreatedProductData['id']);

        $oDeletedProductResponse->assertOk();

        $oDeletedProductResponse->assertJsonCount(1);
    }

    public function testDeleteProductInvalidId()
    {
        $oDeletedProductResponse = $this->deleteJson(self::PRODUCTS_BASE_ROUTE . '/' . 0);

        $oDeletedProductResponse->assertInvalid(['id']);
    }

}
