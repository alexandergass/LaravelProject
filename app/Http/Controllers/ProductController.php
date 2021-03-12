<?php

namespace App\Http\Controllers;

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

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name','ASC')->paginate(10);
        $items = Item::orderBy('title','ASC')->paginate(10);
        return view('products.index')->with('categories',$categories)->with('items', $items);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index2($id)
    {
        $categories = Category::orderBy('name','ASC')->paginate(10);
        $items = Item::where('category_id', $id)->get();
        return view('products.index')->with('categories',$categories)->with('items', $items);
    }

    // public function getAddToCart(Request $request, $id) {

    //     $session_id = Session::getId();

    //     // dd();
    //     // dd(shopping_cart::find($session_id));

    //     // $shopping_cart = shopping_cart::where('session_id', $session_id)->get();

    //     // dd($request->session()->has('cart'));
    //     // dd($request->session()->all());
    //     // dd(Session::has('cart') ? Session::get('cart') : null);

    //     //Cart Model
    //     $oldCart = Session::has('cart') ? Session::get('cart') : null;
    //     // $shopping_cart = shopping_cart::where('session_id', $session_id);
    //     $shopping_cart = shopping_cart::find($id);
    //     $product = Item::find($id);

    //     //Cart Database
    //     // $shopping_cart = shopping_cart::find($id);
    //     // Session::put('cart', $cart);

    //     //moved this to after check if shopping_cart session exists
    //     //not necessary to check when adding initial item
    //     // //check if stock is more than or equal to quantity in shopping cart
    //     // if ($product->quantity > $shopping_cart->quantity) {
    //     //     //not necessary to update stock
    //     //     // $product->quantity--;
    //     //     // $product->save();
    //     // }
    //     // else {
    //     //     return redirect()->route('products.index')->with('error', 'Item is out of stock!');
    //     // }

    //     // $oldCart = Session::has('cart') ? Session::get('cart') : null;

    //     // $cart = new Cart($oldCart);
    //     // $cart->add($product, $product->id);

    //     // $request->session()->put('cart', $cart);
    //     // dd(shopping_cart::where('session_id', $session_id));

    //     // if (shopping_cart::where('session_id', $session_id)) {
    //     // if( $request->session()->has() = null ){
    //     if ($product->quantity > 0) {

    //         //Cart Model
    //         $cart = new Cart($oldCart);
    //         $cart->add($product, $product->id);
    
    //         // $request->session()->put('cart', $cart);
    //         // Session::put('cart', $cart);

    //         //Cart Database
    //         // if(! Session::has('cart')){
    //         // $request->session()->put('cart', $cart);
    //         $scart = session()->get('cart');
    //         if (!$scart){
    //             $shopping_cart = new shopping_cart();
    //             $shopping_cart->item_id = $product->id;
    //             $shopping_cart->session_id = Session::getId();
    //             $shopping_cart->ip_address = $request->ip();
    //             $shopping_cart->quantity++;
    //             $shopping_cart->save();
    //             session()->put('cart', $scart);
    //         }
    //         if (isset($scart[$id])) {
    //             $shopping_cart->quantity++;
    //             $shopping_cart->save();
    //             session()->put('cart', $scart);
    //         } 
    //         // }
    //         // else{
    //         //     $request->session()->put('cart', $cart);

    //             // $shopping_cart->item_id = $product->id;
    //             // $shopping_cart->session_id = Session::getId();
    //             // $shopping_cart->ip_address = $request->ip();
    //             // $shopping_cart->quantity++;
    //             // $shopping_cart->save();
    //         // }
    //         // //Cart Model
    //         // $product->quantity--;
    //         // $product->save();
    //     // }
    //     // else {
    //         // $request->session()->put('cart', $cart);

    //         // $session_id = Session::getId(); 
    //         // $shopping_cart = shopping_cart::find($id);
            
    //         // //check if stock is more than or equal to quantity in shopping cart
    //         // if ($product->quantity > $shopping_cart->quantity) {
    //         // if ($product->quantity > 0) {

    //             //Cart Model
    //             // $cart = new Cart($oldCart);
    //             // $cart->add($product, $product->id);
        
    //             // $request->session()->put('cart', $cart);

    //             //Cart Database
    //             // $shopping_cart->quantity++;

    //             //Cart Model
    //             // $product->quantity--;
    //             // $product->save();
    //         // }
    //         else {
    //             return redirect()->route('products.index')->with('error', 'Item is out of stock!');
    //         }

    //     }

    //     // $shopping_cart->save();

    //     // Session::put('quantity', $request->quantity);
            
    //         //Cart Model
    //         $product->quantity--;
    //         $product->save();

    //     return redirect()->route('products.index')->with('message', 'Item is Added to Cart!');
    // }

    public function getAddToCart(Request $request, $id) {
        // dd(shopping_cart::find($id));
        // dd(Item::find($id));
        // dd(Session::getId());

        $session_id = Session::getId(); 

        if ($session_id == null){
            $categories = Category::orderBy('name','ASC')->paginate(10);
            $items = Item::where('category_id', $id)->get();
            return view('products.index')->with('categories',$categories)->with('items', $items);
        }
        // dd(shopping_cart::where('session_id', $session_id)->first());

        // $request->session()->put('session_id', $session_id);

        $product = Item::find($id);
        
        if ($product->quantity > 0) {

            // if (shopping_cart::find($id) == null) {
            //     $shopping_cart = new shopping_cart();
            //     $shopping_cart->item_id = $id;
            //     $shopping_cart->session_id = Session::getId();
            //     $shopping_cart->ip_address = $request->ip();
            //     $shopping_cart->quantity++;
            // }
            
            //This line here searches for the first record in shopping cart database with current
            //session id and if it doesn't exist it creates a new record.
            if (shopping_cart::where('session_id', $session_id)->first() == null){
                // $request->session()->put('session_id', $session_id);

                $shopping_cart = new shopping_cart();
                $shopping_cart->item_id = $id;
                $shopping_cart->session_id = Session::getId();
                $shopping_cart->ip_address = $request->ip();
                $shopping_cart->quantity++;
            }
            else {
                // $shopping_cart = shopping_cart::find($id);
                $shopping_cart = shopping_cart::where('session_id', $session_id)->first();
                
                $shopping_cart->quantity++;
            }

            // $request->session()->put('session_id', $session_id);

            $shopping_cart->save();

            // Cart Model
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            $cart->add($product, $product->id);
            $request->session()->put('cart', $cart);

            $product->quantity--;
            $product->save();

            return redirect()->route('products.index')->with('message', 'Item is Added to Cart!');
        }

        else {
            return redirect()->route('products.index')->with('error', 'Item out of stock');
        }

    }

    public function getReduceByOne($id){
        //Cart Model
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $product = Item::find($id);
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        //Cart Database
        $session_id = Session::getId(); 
        // dd($shopping_cart = shopping_cart::find($id)->first());
        $shopping_cart = shopping_cart::where('session_id', $session_id)->first();

        $shopping_cart->quantity--;
        $shopping_cart->save();

        // $item = Item::find($id);

        //Cart Model
        $product->quantity++;
        $product->save();

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        // shopping_cart::destroy($id);
        // $shopping_cart = shopping_cart::find($id);
        // $shopping_cart->delete();

        //not necessary to update stock
        //update store quantity in database
        // $product = Item::find($id);
        // $product->quantity++;

        // $product->save();

        return redirect()->route('products.shoppingCart')->with('message', 'Item Removed');
    }

    // public function getRemoveItem($id) {
    //     $oldCart = Session::has('cart') ? Session::get('cart') : null;
    //     $cart = new Cart($oldCart);
    //     $cart->removeItem($id);

    //     if (count($cart->items) > 0) {
    //         Session::put('cart', $cart);
    //     } else {
    //         Session::forget('cart');
    //     }

    //     // Session::put('cart', $cart);
    //     return redirect()->route('products.shoppingCart');
    // }

    public function getCart() {
        if (!Session::has('cart')) {
            return view('products.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('products.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        $categories = Category::all()->sortBy('name');
        return view('products.details')->with('item', $item)->with('categories',$categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    public function updateCart(Request $request)
    {
        //update db and session
        $session_id = Session::getId(); 

        $shopping_cart = shopping_cart::where('session_id', $session_id)->first();

        //$shopping_cart = shopping_cart::where('session_id', '!=', $session_id)->where('item_id','=',$request->item_id)->where('time', '>', time() -600)->first();
        //if (product->quantity - $shopping_cart > $request->quantity)
        
        $product = Item::find($request->cart_id);

        //check if stock is available
        if ( ($product->quantity + $shopping_cart->quantity) >= $request->quantity) {

            $product->quantity += $shopping_cart->quantity;
            $product->quantity -= $request->quantity;

            $product->save();  

            //update item quantity in shopping cart
            $shopping_cart->quantity = $request->quantity;
            $shopping_cart->save();  
            
        }
        else{
            return redirect()->route('products.shoppingCart')->with('error', 'Amount entered exceeds availble stock');
        }

       //update cart model
       $oldCart = Session::has('cart') ? Session::get('cart') : null;
       $cart = new Cart($oldCart);
    //    $product = Item::find($request->cart_id);
       $cart->update($product, $product->id);

    //    $request->session()->put('cart', $cart);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }


    //    $items['item']['qty'] = $request->quantity;

    //    $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // Session::put('quantity', $request->quantity);
        // $request->session()->put('cart', $cart);

        // $request->session()->put('cart', $cart);

        return redirect()->route('products.shoppingCart')->with('message', 'Quantity updated!');
    }

    public function check_order(Request $request)
    {
        // $ip_address = $request->ip();
        // Session::put('ip_address', $ip_address);

        // $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // $shopping_cart = shopping_cart::find($id);
        // $product = Item::find($id);

        $this->validate($request, ['firstName'=>'required|string|max:255',
                                    'lastName'=>'required|string|max:255',
                                    'phoneNumber'=>'required|numeric',
                                    'emailAddress'=>'required|email']); 

        $order_info = new order_info();

        $order_info->session_id = Session::getId();
        $order_info->firstName = $request->firstName;
        $order_info->lastName = $request->lastName;
        $order_info->phoneNumber = $request->phoneNumber;
        $order_info->emailAddress = $request->emailAddress;

        $order_info->save();


        $session_id = Session::getId();
        $shopping_cart = shopping_cart::where('session_id', $session_id)->get();
        // $item = Item::where('session_id', $session_id);
    //    $item = Item::find($request->cart_id);

        
        foreach($shopping_cart as $row){
            $items_sold = new items_sold();
            // $product = Item::find($request->cart_id);

            $item = Item::find($row->item_id);
            // $shopping_cart = shopping_cart::find($row->quantity);

            $items_sold->item_id = $row->item_id;
            $items_sold->order_id = $order_info->id;
            $items_sold->item_price = ($row->quantity * $item->price);
            $items_sold->quantity = $row->quantity;

            $items_sold->save();
        }

        // $order_info = order_info::where('id', $id)->first();

        // $items_sold = items_sold::where('id', $order_info->id)->get();
        
        // $items = Item::where('id', $items_solds->order_id)->get();

        // Session::forget('cart');
        // $request->session()->regenerate();
        
        $oldCart = Session::get('cart');
        // $cart = new Cart($oldCart);
        // return view('products.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);

        Session::forget('cart');

        $request->session()->regenerate();

        $session_id = Session::getId();

        $request->session()->put('session_id', $session_id);

        return view('products.thankyou')->with('items', $oldCart->items)->with('totalPrice', $oldCart->totalPrice)->with('shopping_cart', $shopping_cart)->with('order_info', $order_info)->with('message', 'Order created!');
    }

    public function viewOrders() {
        $orders = items_sold::all();

        // $oldCart = Session::get('cart');

        return view('products.vieworders')->with('orders', $orders);
    }

    public function customerReceipt($id) {
        // $items = Item::find($id);
        // $items = Item::where('id', $id)->get();

        // $oldCart = Session::get('cart');
        // dd(Session::get('cart', $id));

        $oldCart = Session::get('cart', $id);
        $cart = new Cart($oldCart);

        return view('products.receipt')->with('items', $oldCart->items)->with('totalPrice', $oldCart->totalPrice)->with('id', $id);
    }

    public function destroy(Product $product)
    {
        //
    }
}
