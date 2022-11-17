<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Company extends Model
{
    public $timestamps = false;

    protected $table = 'companies';

    protected $fillable = 
    [
        'company_name',
        'street_address',
        'representative_name',
    ];

    public function products() {
        return $this->hasMany('App\Product');
    }
}
