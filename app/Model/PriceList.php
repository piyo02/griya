<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    protected $fillable = [
		'id', 'name','price', 'unit', 'created_at', 'updated_at'
    ];
}
