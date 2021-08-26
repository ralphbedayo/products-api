<?php


namespace Tests\Feature\Product\Create;


use Tests\Feature\BaseFeatureTest;

class ProductCreateFeatureTest extends BaseFeatureTest
{
    public function testCreateProduct()
    {
        $oResponse = $this->postJson(self::PRODUCTS_BASE_ROUTE, self::EXAMPLE_PRODUCT_DATA);

        $oResponse->assertOk();
        $oResponse->assertJsonCount(4, 'data');
    }

    public function testCreateProductInvalidName()
    {
        $aInvalidData = self::EXAMPLE_PRODUCT_DATA;
        $aInvalidData['name'] = '';

        $oResponse = $this->postJson(self::PRODUCTS_BASE_ROUTE, $aInvalidData);

        $oResponse->assertInvalid(['name']);
    }

    public function testCreateProductInvalidDescription()
    {
        $aInvalidData = self::EXAMPLE_PRODUCT_DATA;
        $aInvalidData['description'] = '';

        $oResponse = $this->postJson(self::PRODUCTS_BASE_ROUTE, $aInvalidData);

        $oResponse->assertInvalid(['description']);
    }

    public function testCreateProductInvalidPrice()
    {
        $aInvalidData = self::EXAMPLE_PRODUCT_DATA;
        $aInvalidData['price'] = '';

        $oResponse = $this->postJson(self::PRODUCTS_BASE_ROUTE, $aInvalidData);

        $oResponse->assertInvalid(['price']);
    }

}
