<?php

Route::post('/register', 'Auth\RegisterController@register')->name('user.register');
Route::post('/verify_account', 'Auth\RegisterController@verifyAccount')->name('user.verifyAccount');
Route::get('/verify_account/{code}', 'Auth\RegisterController@verifyAccountLink')->name('user.verifyAccountLink');

Route::get('/redirect/{service}', 'SocialAuthController@redirect')->name('sociallogin');
Route::get('/callback/{service}', 'SocialAuthController@callback')->name('sociallogincallback');

Route::get('/page/{slug}', 'Pages\PagesController@getPages')->name('getPageInfo');
Route::get('/faqs', 'Pages\PagesController@getFaqs')->name('getFaqs');
Route::get('/login', 'Auth\RegisterController@showLoginForm')->name('login');
Route::post('/ajaxlogin', 'Auth\RegisterController@login')->name('user.login');
Route::get('/resend_code', 'Auth\RegisterController@resendCode')->name('user.resendCode');
Route::get('/getShippingMethodInfo', 'Cart\CartController@getShippingMethodInfo')->name('user.getShippingMethodInfo');
Route::get('/geift_card', 'GiftCard\GiftCardController@giftCard')->name('user.giftCard');
Route::get('/getAddressDetails', 'Customer\CustomerController@getAddressDetails')->name('user.getAddressDetails');
Route::get('/get_provience/{country_id}', 'Customer\CustomerController@getProvience')->name('user.getProvience');
Route::get('/get_cities/{provience_id}', 'Customer\CustomerController@getCities')->name('user.getCities');
Route::middleware(['auth'])->group(function () {

    Route::get('/account-info', 'Auth\UsersController@accountInfo')->name('account-info');

    Route::get('/gift-card-details/{id}',   'GiftCard\GiftCardController@cardInfo')->name('cardInfo');
    Route::post('/send_giftcard',           'GiftCard\GiftCardController@sendGiftCard')->name('send_giftcard');

    Route::get('/my_profile',              'Customer\CustomerController@myProfile')->name('customer.my_profile');
    Route::get('/address_book',            'Customer\CustomerController@addressBook')->name('customer.address_book');
    Route::get('/address_book/{id}',       'Customer\CustomerController@editAddressBook')->name('customer.edit_address_book');
    Route::get('/delete_address_book/{id}', 'Customer\CustomerController@deleteAddressBook')->name('customer.delete_address_book');
    Route::get('/create_address_book',     'Customer\CustomerController@createAddressBook')->name('customer.create_address_book');
    Route::post('/saveAddress',              'Customer\CustomerController@saveAddress')->name('customer.saveAddress');
    Route::get('/wishlist',                'Customer\CustomerController@wishList')->name('customer.wishlist');
    Route::post('/customer/removeFromWishList',      'Customer\CustomerController@removeFromWishList')->name('customer.removeFromWishList');
    Route::post('/place_order',             'Orders\OrdersController@placeOrder')->name('customer.place_order');
    Route::post('/place_card_order',             'Orders\OrdersController@placeCardOrder')->name('customer.place_card_order');
    Route::post('/apply_discount',           'Checkout\CheckoutController@applyDiscount')->name('customer.apply_discount');

    Route::post('/addAddress',             'Customer\CustomerController@addAddressAjax')->name('customer.addAddress');

    Route::get('/order_history',           'Customer\CustomerController@orderHistory')->name('customer.order_history');
    Route::get('/order/{id}',           'Customer\CustomerController@orderSubmission')->name('customer.order_submission');
    Route::get('/order-detatils/{unique_id}',           'Customer\CustomerController@orderDetails')->name('customer.order_details');
    Route::get('/orders/more',           'Orders\OrdersController@orders')->name('customer.orders');
    Route::get('/order_track',             'Customer\TrackingOrderController@orderTrack')->name('customer.order_track');
    Route::get('/notification_setting',    'Customer\CustomerController@notificationSettings')->name('customer.notification_setting');
    Route::get('/updatenotification_setting',    'Customer\CustomerController@updateNotificationSettings')->name('customer.updatenotification_setting');

    Route::post('/update_profile',           'Customer\CustomerController@updateProfile')->name('customer.update_profile');
    Route::get('/logout',                   'Auth\UsersController@logout')->name('logout');
    Route::get('/shop_by_interest', 'Customer\CustomerController@shopByInterest')->name('customer.shop_by_interest');
    Route::post('/save_shop_by_interest', 'Customer\CustomerController@StoreShopByInterest')->name('customer.save_shop_by_interest');
});
