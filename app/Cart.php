<?php

namespace App;

use App\Product;
use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\Cart;
use App\shopping_cart;
use App\order_info;
use App\items_sold;
use Image;
use Storage;
use Session;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id) {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        
        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $item->price;

    }

    public function reduceByOne($id){
        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['price'];

        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }

    }

    public function update($item, $id) {
        $storedItem = ['qty' => $item->quantity, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        
        //subtract old item quantity and price from cart total quantity
        //THEN clear item quantity
        $this->totalPrice -= $storedItem['price'];
        $this->totalQty -= $storedItem['qty'];
        $storedItem['qty'] = 0;

        //here I set the model qty equal to the quantity in my shopping_cart database
        //and recalculated price for the item
        // $shopping_cart = shopping_cart::find($id);
        // dd(shopping_cart::find($id));
        $session_id = Session::getId(); 
        $shopping_cart = shopping_cart::where('session_id', $session_id)->first();

        $storedItem['qty'] = $shopping_cart->quantity;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        
        //add new (item quantity * item price) to total price
        $this->items[$id] = $storedItem;
        $this->totalQty += $storedItem['qty'];
        $this->totalPrice += $item->price * $storedItem['qty'] ;

        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }
    }

    // public function removeItem($id) {
    //     $this->totalQty -= $this->items[$id]['qty'];
    //     $this->totalPrice -= $this->items[$id]['price'];
    //     unset($this->items[$id]);
    // }
}
