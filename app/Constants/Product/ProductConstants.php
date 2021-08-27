<?php


namespace App\Constants\Product;


class ProductConstants
{
    const REQUIRED_PRODUCT_ID_VALIDATION_RULE = ['id' => 'required|exists:product,id,deleted_at,NULL'];

    const UPDATE_PRODUCT_PARAMS = ['name', 'description', 'price'];

}
