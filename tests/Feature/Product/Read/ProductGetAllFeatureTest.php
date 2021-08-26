<?php


namespace Tests\Feature\Product\Read;


use Tests\Feature\BaseFeatureTest;

class ProductGetAllFeatureTest extends BaseFeatureTest
{

    public function testGetAllProducts()
    {
        $this->seed();
        $oResponse = $this->getJson(self::PRODUCTS_BASE_ROUTE);

        $oResponse->assertOk();
    }

    public function testGetAllProductsWithoutSeed()
    {
        $oResponse = $this->getJson(self::PRODUCTS_BASE_ROUTE);

        $oResponse->assertOk();
    }

}
