<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
