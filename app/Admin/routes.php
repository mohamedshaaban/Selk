<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/download_file/{folder_name}/{file_name}', 'HomeController@downloadFile');
    $router->resource('sliders', \Sliders\SlidersController::class);
    $router->resource('careers', \Common\CareerController::class);

    $router->resource('posts_categories', \PostsCategories\PostsCategoriesController::class);
    $router->resource('posts', \Posts\PostsController::class);
    $router->resource('pages', \Pages\PagesController::class);
    $router->resource('settings', \Settings\SettingsController::class);
    $router->resource('faqs', \Faqs\FaqsController::class);
    $router->resource('categories', \Categories\CategoriesController::class);
    $router->resource('brands', \Brands\BrandsController::class);
    $router->resource('characters', \Characters\CharactersController::class);
    $router->resource('tags', \Tags\TagsController::class);
    $router->resource('products', \Products\ProductsController::class);
    $router->post('product/generate_options_table', '\App\Admin\Controllers\Products\ProductsController@generateOptionsTable');
    $router->resource('options', \Products\OptionsController::class);
    $router->resource('offers', \Offers\OffersController::class);
    $router->resource('coupons', \Coupons\CouponsController::class);
    $router->resource('promotions', \Promotions\PromotionsController::class);
    $router->resource('order_amount_offer', \OrderAmountOffers\OrderAmountOffersController::class);
    $router->resource('pre_order', \Orders\PreOrderController::class);
    $router->resource('currencies', \Currencies\CurrencyController::class);
    $router->resource('home_page_gift_box', \HomePageGiftBox\HomePageGiftBoxController::class);
    $router->resource('suppliers', \Suppliers\SuppliersController::class);
    $router->resource('orderstatus', \OrderStatus\OrderStatusController::class);

    




    $router->resource('giftcards', \GiftCards\GiftCardsController::class);
    $router->resource('countries', \Countries\CountriesController::class);
    $router->resource('province', \Province\ProvienceController::class);
    $router->resource('shippingmethods', \ShippingMethods\ShippingMethodsController::class);
    $router->resource('dhl_shipping_method', \ShippingMethods\DhlShippingMethodsController::class)->names('dhl_shipping_conf');
    $router->resource('shipping_settings', \ShippingMethods\ShippingSettingsController::class);
    
    
    
    $router->resource('customers', \Customers\CustomersController::class);
    //    $router->resource('orders', \Orders\OrdersController::class);
    $router->get('/preview_card/{id}', '\App\Admin\Controllers\GiftCards\GiftCardsController@previewCard')->name('viewCard');

    $router->get('vend', "\App\Admin\Controllers\Vend\VendController@index")->name('vend');
    $router->get('vend/log', "\App\Admin\Controllers\Vend\VendLogController@index")->name('vend.log');
    $router->get('vend/log/{id}', "\App\Admin\Controllers\Vend\VendLogController@show")->name('vend.log.view');

    $router->group(['prefix' => "vend/ajax", 'as' => 'vend.ajax.'], function (Router $router) {

        $router->get('brands', "\App\Admin\Controllers\Vend\VendController@brand")->name("brands");
        $router->get('suppliers', "\App\Admin\Controllers\Vend\VendController@suppliers")->name("suppliers");
        $router->get('products', "\App\Admin\Controllers\Vend\VendController@products")->name("products");
        $router->get('inventory', "\App\Admin\Controllers\Vend\VendController@inventory")->name("inventory");
        $router->get('payment_types', "\App\Admin\Controllers\Vend\VendController@payment_type")->name("payment_types");
    });


    $router->resource('order', Order\OrderController::class)->names('admin_order');
    $router->resource('order_shipment', Order\DhlController::class)->names('admin_order_shipment');
    
    
    $router->get('ajax/customer', Order\OrderController::class . '@customer_ajax')->name('ajax.customer');
    $router->get('ajax/product', Order\OrderController::class . '@product_ajax')->name('ajax.product');
    $router->get('giftcards/preview', GiftCards\GiftCardsController::class . '@approvecard')->name('ajax.approvecard');
});
