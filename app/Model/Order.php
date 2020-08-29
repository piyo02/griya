<?php

namespace App\Model;
use DB;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'state_id',
        'date',
        'description',
    ];
}
