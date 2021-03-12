<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('auth.login');
});

Route::post("auth.login","HomeController@index");

Route::get('/add-to-cart/{id}', [
    'uses' => 'ProductController@getAddToCart',
    'as' => 'products.addToCart'
]);

Route::get('/reduce/{id}', [
    'uses' => 'ProductController@getReduceByOne',
    'as' => 'products.reduceByOne'
]);

// Route::get('/remove/{id}', [
//     'uses' => 'ProductController@getRemoveItem',
//     'as' => 'products.remove'
// ]);

Route::get('/shopping-cart', [
    'uses' => 'ProductController@getCart',
    'as' => 'products.shoppingCart'
])->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('delete/{id}','CategoryController@destroy');
Route::get('item/{id}','ProductController@index2')->name('index2');
Route::put('item/updateCart', 'ProductController@updateCart')->name('products.updateCart');
Route::post('check_order', 'ProductController@check_order')->name('products.check_order');
// Route::get('check_order/{id}', 'ProductController@check_order')->name('products.check_order');
Route::get('viewOrders', 'ProductController@viewOrders')->name('products.viewOrders')->middleware('auth');
Route::get('customerReceipt/{id}', 'ProductController@customerReceipt')->name('products.customerReceipt');

Route::resource('items', 'ItemController')->middleware('auth');
Route::resource('categories', 'CategoryController')->middleware('auth');
Route::resource('products', 'ProductController')->middleware('auth');

Auth::routes();
