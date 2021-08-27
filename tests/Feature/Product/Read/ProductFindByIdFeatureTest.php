<?php


namespace Tests\Feature\Product\Read;


use Tests\Feature\BaseFeatureTest;

class ProductFindByIdFeatureTest extends BaseFeatureTest
{

    public function testFindProductById()
    {
        $aCreatedProductData = $this->createExampleProduct();

        $oResponse = $this->getJson(self::PRODUCTS_BASE_ROUTE . '/' . $aCreatedProductData['id']);
        $oResponse->assertOk();
    }

    public function testFindProductByIdInvalidId()
    {
        $oResponse = $this->getJson(self::PRODUCTS_BASE_ROUTE . '/' . 0);
        $oResponse->assertInvalid(['id']);
    }
}
