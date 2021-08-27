<?php


namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class BaseFeatureTest extends TestCase
{
    use RefreshDatabase;

    const EXAMPLE_PRODUCT_DATA = [
        'name'        => 'Example Product Name',
        'description' => 'Example Product Description',
        'price'       => 15.25
    ];

    const PRODUCTS_BASE_ROUTE = '/api/products';


    public function createExampleProduct()
    {
        $oResponse = $this->postJson(self::PRODUCTS_BASE_ROUTE, self::EXAMPLE_PRODUCT_DATA);
        $oResponse->assertOk();

        return json_decode($oResponse->getContent(), true)['data'];
    }
}
