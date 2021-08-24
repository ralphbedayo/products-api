<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $table = 'product';

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price'
    ];
}
