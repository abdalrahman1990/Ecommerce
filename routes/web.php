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

/**
 *  Basic Routes
 */
Route::get('/', 'HomeController@index')->name('index');
Route::get('/products', 'HomeController@products')->name('products');
Route::get('/products/{slug}','HomeController@showProduct')->name('product-details');
Route::get('/about', 'HomeController@about')->name('about');

//Search Route(s)
Route::prefix('/search')->group(function(){
    //Handle Normal Search
    Route::get('/','SearchController@search')->name('search');

    //Handle Ajax Search
    Route::get('/{str}','SearchController@ajaxSearch');
});

/**
 * Contact Route(s)
 */
Route::post('/contact','ContactController@store')->name('contact');

/**
 *  Checkout Route(s)
 */
Route::prefix('checkout')->group(function(){
    Route::get('/', 'HomeController@checkout')->name('checkout');
    Route::post('/','OrderController@store');
});

/**
 *  Customer (User) Profile Route(s)
 */
Route::prefix('/profile')->group(function(){
    Route::get('/','ProfileController@show')->name('profile');
    Route::post('/','ProfileController@update');
    Route::delete('/{id}','ProfileController@destroy')->name('profile.destroy');
});

/**
 *  Customer order history Route(s)
 */
Route::prefix('order/history')->name('order.')->group(function(){
    Route::get('/','OrderController@index')->name('index');
    Route::get('/{id}','OrderController@show')->name('show');
});

// get the braintree client token
Route::get('/braintree/token','BraintreeController@token');

/**
 *  Customer Wishlist Route(s)
 */
Route::prefix('wishlist')->name('wishlist.')->group(function(){
    Route::post('/add', 'WishlistsController@store')->name('add');
    Route::get('/','WishlistsController@index')->name('index');
    Route::delete('/{id}','WishlistsController@destroy')->name('destroy');
});

/**
 *  Reviews Route(s)
 */
Route::post('/review','ReviewsController@store')->name('reviews.store');


/**
 *  Cart Route(s)
 */
Route::prefix('/cart')->name('cart.')->group(function(){
    Route::get('/', 'HomeController@cart')->name('index');
    Route::post('/add','CartController@addCart');
    Route::post('/update','CartController@updateCart');
});

// Generate Authentication routes for Users
Auth::routes();

//Email confirmation Route(s)
Route::name('auth.resend_confirmation')
    ->get('/register/confirm/resend', 'Auth\RegisterController@resendConfirmation');

Route::name('auth.confirm')
    ->get('/register/confirm/{confirmation_code}', 'Auth\RegisterController@confirm');

// Admin Route(s)
Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){
    /**
     *  Authentication Route(s)
     */
    Route::namespace('Auth')->group(function(){  
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
        Route::post('/logout', 'LoginController@logout')->name('logout');
        Route::get('/register', 'RegisterController@showRegisterationForm')->name('register');
        Route::post('/register', 'RegisterController@register');
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/reset', 'ResetPasswordController@reset');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    });

    /**
     *  Dashboard Route(s)
     */
    Route::get('/dashboard' , 'DashboardController@index')->name('dashboard');

    /**
     *  Admin Profile
     */
    Route::get('/dashboard/profile','ProfileController@show')->name('profile');
    Route::post('/dashboard/profile','ProfileController@update');

    /**
     *  Product Route(s)
     */
    Route::resource('/products', 'ProductsController');

    /**
     *  Categories Route(s)
     */
    Route::resource('/categories', 'CategoriesController');

    /**
     *  Orders Route(s)
     */
    Route::resource('/orders','OrdersController');
    Route::get('orders/{id}/products','OrdersController@editProduct')->name('orders.products');
    Route::post('orders/{id}/products','OrdersController@updateOrderedProduct');
    Route::post('orders/{id}/products/add','OrdersController@addProduct')->name('orders.products.add');
    /**
     *  Payments Route(s)
     */
    Route::resource('/payments','PaymentsController');

    /**
     *  Customers (Users) Route(s)
     */
    Route::resource('/customers','CustomersController');

    /**
     *  Addresses Route(s)
     */
    Route::resource('/addresses','AddressesController');

    /**
     *  Customer Reviews Route(s)
     */
    Route::resource('/reviews','ReviewsController');

    /**
     *  Reports Route(s)
     */
    Route::get('/reports','ReportsController@index')->name('reports.index');
    
    Route::prefix('/reports')->namespace('Reports')->name('reports.')->group(function(){
        Route::get('/pdf','PDFController@makePDFReport')->name('pdf');
        Route::get('/excel','ExcelController@makeExcelReport')->name('excel');
        Route::get('/csv','CSVController@makeCSVReport')->name('csv');
    });

    /**
     * Contact messages Route(s)
     */
    Route::resource('/contacts','ContactController');

    /**
     * Cities Route(s)
     */
    Route::resource('/cities','CitiesController');
});
