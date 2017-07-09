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
});