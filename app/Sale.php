<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Sale extends Model
{
    public $timestamps = false;

    protected $table = 'sales';

    public function products() {
        return $this->belongsTo('App\Product');
        }

}
