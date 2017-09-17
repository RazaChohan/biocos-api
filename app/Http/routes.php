<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$app->get('/', function () {
    return 'Hi, I am biocos API!!!';
});
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    /***
     * Login Route
     */
    $api->post('/login', 'App\Http\Controllers\AuthController@login');
    /***
     * Register Route
     */
    $api->post('/register', 'App\Http\Controllers\AuthController@register');
    /***
     * List jobs call
     */
    $api->get('/list-jobs', 'App\Http\Controllers\JobController@listJobs');
    /***
     * List region call
     */
    $api->get('/list-regions', 'App\Http\Controllers\RegionController@listRegions');
    /***
     * List Customer call
     */
    $api->get('/list-customers', 'App\Http\Controllers\CustomerController@listCustomers');
    /***
     * List products call
     */
    $api->get('/list-products', 'App\Http\Controllers\ProductController@listProducts');
    /***
     * Get Product Details
     */
    $api->get('/product-details/{productId}', 'App\Http\Controllers\ProductController@productDetail');
    /***
     * Get User details api call
     */
    $api->get('/user-info/{userId?}', 'App\Http\Controllers\UserController@userInfo');
    /***
     * Put Book or update order
     */
    $api->put('/book-update-order/{orderId?}', 'App\Http\Controllers\OrderController@bookOrUpdateOrder');
    /***
     * Get Order Details
     */
    $api->get('/order-details/{orderId}', 'App\Http\Controllers\OrderController@getOrderDetails');
    /***
     * Add or Update Customer
     */
    $api->put('/add-update-customer/{customerId?}', 'App\Http\Controllers\CustomerController@addOrUpdateCustomer');
    /***
     * Get Customer Details
     */
    $api->get('/customer-details/{customerId}', 'App\Http\Controllers\CustomerController@getCustomerDetails');
    /***
     * Add or Update Customer
     */
    $api->put('/add-update-region/{regionId?}', 'App\Http\Controllers\RegionController@addOrUpdateRegion');
    /***
     * List orders
     */
    $api->get('/list-orders', 'App\Http\Controllers\OrderController@listOrders');
    /***
     * Get Constants
     */
    $api->get('/get-constants', 'App\Http\Controllers\Controller@getConstants');
    /***
     * Update profile
     */
    $api->put('/update-profile/{userId}', 'App\Http\Controllers\UserController@updateProfile');
    /***
     * Update jobs order
     */
    $api->put('/update-jobs-order', 'App\Http\Controllers\JobController@updateJobsOrder');
    /***
     * Sync Data
     */
    $api->put('/sync-data', 'App\Http\Controllers\Controller@syncData');
    /***
     * Add or update payment received
     */
    $api->put('/add-update-payment-received', 'App\Http\Controllers\OrderController@addOrUpdatePaymentReceived');
    /***
     * Assign or Update Regions
     */
    $api->put('/assign-update-regions', 'App\Http\Controllers\RegionController@assignOrUpdateRegions');
    /***
     * Get User regions
     */
    $api->get('list-user-regions', 'App\Http\Controllers\RegionController@listUserRegions');
    /***
     * Insert user locations
     */
    $api->put('/add-user-locations', 'App\Http\Controllers\UserController@addUserLocations');
    /****
     * List user locations
     */
    $api->get('list-user-locations', 'App\Http\Controllers\UserController@listUserLocations');
    /***
     * List payment received
     */
    $api->get('list-customer-payments', 'App\Http\Controllers\OrderController@listPaymentReceived');
    /***
     * Update Order Status Order
     */
    $api->post('update-order-status', 'App\Http\Controllers\OrderController@updateOrderStatus');
    /****
     * Log no order API
     */
    $api->post('log-no-order', 'App\Http\Controllers\JobController@logNoOrder');
    /***
     * Migrate Endpoint
     */
    $api->get('/migrate', function()
    {
        echo 'init with app tables migrations...';
        \Illuminate\Support\Facades\Artisan::call('migrate');
        echo 'done with app tables migrations';
    });
});