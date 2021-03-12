<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\Cart;
use Image;
use Storage;
use Session;
// use Intervention\Image\ImageManagerStatic as Image;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('title','ASC')->paginate(10);
        return view('items.index')->with('items', $items);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->sortBy('name');
        return view('items.create')->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //dd(storage_path());;
        //validate the data
        // if fails, defaults to create() passing errors
        $this->validate($request, ['title'=>'required|string|max:255',
                                   'category_id'=>'required|integer|min:0',
                                   'description'=>'required|string',
                                   'price'=>'required|numeric',
                                   'quantity'=>'required|integer',
                                   'sku'=>'required|string|max:100',
                                   'picture' => 'required|image']); 

        //send to DB (use ELOQUENT)
        $item = new Item;
        $item->title = $request->title;
        $item->category_id = $request->category_id;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->quantity = $request->quantity;
        $item->sku = $request->sku;

        //save image
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $time = time();
            $filename = $time . '.' . $image->getClientOriginalExtension();
            $location ='images/items/' . $filename;

            $image = Image::make($image);
            Storage::disk('public')->put($location, (string) $image->encode());
            $item->picture = $filename;
        }

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');

            $filename2 = 'tn_'. $time . '.' . $image->getClientOriginalExtension();
            $location2 ='images/items/' . $filename2;

            $image = Image::make($image);
            Storage::disk('public')->put($location2, (string) $image->resize(300, 300)->encode());
            //$item->picture = $filename;
        }

        // if ($request->hasFile('picture')) {
        //     $image = $request->file('picture');

        //     $filename2 = 'lrg_'. $time . '.' . $image->getClientOriginalExtension();
        //     $location2 ='images/items/' . $filename2;

        //     $image = Image::make($image);
        //     Storage::disk('public')->put($location2, (string) $image->resize(300, 300)->encode());
        //     //$item->picture = $filename;
        // }

        // Get the instance of the item I just inserted
       // $item = Item::update($parameters);
/*
        // Set the driver
        Image::configure(array('driver' => 'gd'));

        // If we simply dd(storage_path), we will get 'project/store/', but it's not what we want.
        // So we append 'app/public/', that's the internal file address
        // Note that when resizing images, the target is in internal directory
        // Also, after resizing, we save it with the same name in the same place.
        Image::make(storage_path('app/public/' . $item->image))
        ->resize(300, 300)
        ->save(storage_path('app/public/' . $item->image));
*/
        $item->save(); //saves to DB

        //Forgot this
        // $product = Item::find($item->id);
        // $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // $cart = new Cart($oldCart);
        // $cart->add($product, $product->id);
        // $request->session()->put('cart', $cart);

        // Cart Model
        // $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // $cart = new Cart($oldCart);
        // $cart->add($product, $product->id);
        // $request->session()->put('cart', $cart);

        // $product->price = $request->price;
        // $product->quantity = $request->quantity;
        // $product->save();

        // dd('success');
        Session::flash('success','The item has been added');

        //redirect
        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        $categories = Category::all()->sortBy('name');
        return view('products.details')->with('categories',$categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        $categories = Category::all()->sortBy('name');
        return view('items.edit')->with('item',$item)->with('categories',$categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate the data
        // if fails, defaults to create() passing errors
        $item = Item::find($id);
        $this->validate($request, ['title'=>'required|string|max:255',
                                   'category_id'=>'required|integer|min:0',
                                   'description'=>'required|string',
                                   'price'=>'required|numeric',
                                   'quantity'=>'required|integer',
                                   'sku'=>'required|string|max:100',
                                   'picture' => 'sometimes|image']);             

        //send to DB (use ELOQUENT)
        $item->title = $request->title;
        $item->category_id = $request->category_id;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->quantity = $request->quantity;
        $item->sku = $request->sku;

        //save image
        if ($request->hasFile('picture')) {

            //remove old file with item->picture
            $oldFilename = $item->picture;
            Storage::delete('public/images/items/'.$oldFilename);   
            Storage::delete('public/images/items/'.'tn_'.$oldFilename);   
            
            $image = $request->file('picture');
            $time = time();
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location ='images/items/' . $filename;

            $image = Image::make($image);
            Storage::disk('public')->put($location, (string) $image->encode());

            if (isset($item->picture)) {
                $oldFilename = $item->picture;
                Storage::delete('public/images/items/'.$oldFilename);                
            }

            $item->picture = $filename;
        }

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');

            $filename2 = 'tn_'. $time . '.' . $image->getClientOriginalExtension();
            $location2 ='images/items/' . $filename2;

            $image = Image::make($image);
            Storage::disk('public')->put($location2, (string) $image->resize(300, 300)->encode());
            //$item->picture = $filename;
        }

        $item->save(); //saves to DB

        Session::flash('success','The item has been updated');

        //redirect
        return redirect()->route('items.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $item = Item::find($id);
        if (isset($item->picture)) {
            $oldFilename = $item->picture;
            Storage::delete('public/images/items/'.$oldFilename);   
            Storage::delete('public/images/items/'.'tn_'.$oldFilename);                
        }
        $item->delete();

        Session::flash('success','The item has been deleted');

        return redirect()->route('items.index');

    }
}
