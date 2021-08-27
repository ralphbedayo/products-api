<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * Transforms returned product data
     *
     * @param $oProductModel
     * @return array
     */
    public function transform($oProductModel)
    {
        return [
            'id'          => $oProductModel->id,
            'name'        => $oProductModel->name,
            'description' => $oProductModel->description,
            'price'       => $oProductModel->price
        ];
    }
}
