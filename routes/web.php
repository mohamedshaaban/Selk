<?php
require_once 'customer.php';
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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');

Route::get('/products', 'Products\ProductsController@index')->name('website.product.index');
Route::get('/products/new', 'Products\ProductsController@newProducts')->name('website.product.new');
Route::get('/product/{id}', 'Products\ProductsController@show')->name('website.product.show');
Route::get('/products/filter', 'Products\ProductsController@filter')->name('website.product.filter');
Route::get('/product/{id}/calc_price', 'Products\ProductsController@calcPrice')->name('website.product.calc_price');
Route::post('/product/notify_customer_once_ava', 'Products\ProductsController@notifyCustomerOnceAvailable')->name('website.product.notify_customer_once_ava');
Route::post('/product/add_review', 'Products\ProductsController@addReview')->name('website.product.add_review');
Route::get('/products/auto_complete_tags', 'Products\ProductsController@autoCompleteTags')->name('website.product.auto_complete_tags');
Route::get('/products/shop_by_interest', 'Products\ProductsController@shopByInterest')->name('website.product.shop_by_interest');

Route::get('/page/{slug}', 'Pages\PagesController@getPages')->name('getPageInfo');
Route::get('/faqs', 'Pages\PagesController@getFaqs')->name('getFaqs');
//carrer
Route::get('/career', 'Common\CareerController@index')->name('website.common.career');
Route::post('/career', 'Common\CareerController@store')->name('website.career.save');

//contactus
Route::get('/contact_us', 'Common\ContactUsController@index')->name('website.common.contact_us');
Route::post('/contact_us', 'Common\ContactUsController@store')->name('website.contact_us.save');
//sitemap
Route::get('/sitemap', 'Common\ContactUsController@sitemap')->name('website.common.sitemap');


Route::get('/categories', 'Categories\CategoriesController@index')->name('website.categories.index');
Route::get('/categories/filter', 'Categories\CategoriesController@filter')->name('website.categories.filter');

Route::get('/brands', 'Brands\BrandsController@index')->name('website.brands.index');
Route::get('/brands/filter', 'Brands\BrandsController@filter')->name('website.brands.filter');

Route::get('/characters', 'Characters\CharactersController@index')->name('website.characters.index');
Route::get('/characters/filter', 'Characters\CharactersController@filter')->name('website.characters.filter');

// cart
Route::prefix('cart')->group(function () {
    Route::get('/get', 'Cart\CartController@get')->name('website.cart.get');
    Route::post('/add', 'Cart\CartController@add')->name('website.cart.add');
    Route::get('/remove', 'Cart\CartController@delete')->name('website.cart.remove');
    Route::post('/update', 'Cart\CartController@update')->name('website.cart.update');
});
Route::prefix('giftcart')->group(function () {
    Route::get('/get', 'giftcart\CartController@get')->name('website.cart.get');
    Route::post('/add', 'giftcart\CartController@add')->name('website.cart.add');
    Route::get('/remove', 'giftcart\CartController@delete')->name('website.cart.remove');
    Route::post('/update', 'giftcart\CartController@update')->name('website.cart.update');
    Route::post('/validation', 'giftcart\CartController@validation');
});
// cart
Route::prefix('checkout')->group(function () {
    Route::get('get_shipping_methods', 'Checkout\CheckoutController@getShippingMethod')->name('website.checkout.get_shipping_method');
    Route::get('', 'Checkout\CheckoutController@checkout')->name('website.checkout.my_cart');
    Route::get('/my_cart', 'Checkout\CheckoutController@myCart')->name('website.checkout.my_cart');
});

Route::post('/customer/add_to_wishlist', 'Customer\CustomerController@addToWishlist')->name('website.customer.add_to_wishlist');

// vend
Route::any('/vend/inventory', 'Integration\VendController@updateInventory')->name('vend.inventory_update');
//currency
Route::group(['middleware' => 'currency'], function () {
    Route::get('/change_currency', function (Illuminate\Http\Request $request) {
        return $request->session()->get('currency');
    })->name('change_currency');
});

// switch language
Route::get('/switch_lang/{locale}', function ($locale = '') {
    session(['locale' => $locale]);
    App::setLocale($locale);

    return redirect()->back();
})->name('switch_lang');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/knet/success', 'Knet\KnetController@success')->name('knet.success');
Route::post('/knet/failure', 'Knet\KnetController@failure')->name('knet.failure');
