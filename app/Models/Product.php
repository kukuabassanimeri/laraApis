<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    # Fillable Properties 
    protected $fillable = [
        'name',
        'slug',
        'description', 
        'price'
    ];
}
