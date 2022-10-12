<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    protected $table = 'products';

    protected $fillable = 
    [
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];
}