<?php


namespace App\Repositories\Product;


use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{

    protected $fieldSearchable = [
        'id'          => '=',
        'name'        => 'like',
        'description' => 'like',
    ];

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Product::class;
    }
}
