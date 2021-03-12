<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class items_sold extends Model
{
    protected $fillable = ['item_id', 'order_id', 'item_price', 'quantity'];
}
