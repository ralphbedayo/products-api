<?php


namespace Tests\Feature\Product\Update;


use Illuminate\Support\Str;
use Tests\Feature\BaseFeatureTest;

class ProductUpdateFeatureTest extends BaseFeatureTest
{
    public function testUpdateProduct()
    {
        $aCreatedProductData = $this->createExampleProduct();
        $aUpdateData = [
            'name'        => 'Example Name Updated',
            'description' => 'Example Description Updated',
            'price'       => 25.50,
        ];

        $oResponse = $this->putJson(self::PRODUCTS_BASE_ROUTE . '/' . $aCreatedProductData['id'], $aUpdateData);
        $oResponse->assertOk();

        $aResponseContent = json_decode($oResponse->getContent(), true);

        foreach ($aUpdateData as $sField => $sUpdateData) {
            $this->assertEquals($sUpdateData, $aResponseContent['data'][$sField]);
        }

    }

    public function testUpdateProductInvalidName()
    {
        $aCreatedProductData = $this->createExampleProduct();

        $sRandomString = Str::random(500);

        $aUpdateData = [
            'name' => $sRandomString
        ];

        $oResponse = $this->putJson(self::PRODUCTS_BASE_ROUTE . '/' . $aCreatedProductData['id'], $aUpdateData);

        $oResponse->assertInvalid(['name']);
    }

    public function testUpdateProductInvalidDescription()
    {
        $aCreatedProductData = $this->createExampleProduct();

        $sRandomString = Str::random(2001);

        $aUpdateData = [
            'description' => $sRandomString
        ];

        $oResponse = $this->putJson(self::PRODUCTS_BASE_ROUTE . '/' . $aCreatedProductData['id'], $aUpdateData);

        $oResponse->assertInvalid(['description']);
    }

    public function testUpdateProductInvalidPrice()
    {
        $aCreatedProductData = $this->createExampleProduct();

        $sRandomString = Str::random(5);

        $aUpdateData = [
            'price' => $sRandomString
        ];

        $oResponse = $this->putJson(self::PRODUCTS_BASE_ROUTE . '/' . $aCreatedProductData['id'], $aUpdateData);

        $oResponse->assertInvalid(['price']);
    }

}
