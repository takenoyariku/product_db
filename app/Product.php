<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sale;

class Product extends Model
{
    public $timestamps = false;

    protected $table = 'products';

    protected $fillable = 
    [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    public function sales() {
        return $this->hasMany('App\Sale');
    }
    public function companies() {
        return $this->belongsTo('App\Company', 'company_id');
    }
}
