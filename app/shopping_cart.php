<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shopping_cart extends Model
{
    public $timestamps = false;

    public function item() {
        
        return $this->belongsTo('\App\Item','item_id', 'id')->orderBy('title','ASC');
    }
    public function itemprice() {
        
        return $this->belongsTo('\App\Item','item_id', 'id')->orderBy('price','ASC');
    }
}
