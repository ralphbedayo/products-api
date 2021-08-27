<?php


namespace Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class BaseUnitTest extends TestCase
{
    use RefreshDatabase;

    const EXAMPLE_PRODUCT_DATA = [
        'name'        => 'Example Product Name',
        'description' => 'Example Product Description',
        'price'       => 15.25
    ];

}
