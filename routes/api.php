<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API route for login user
Route::post('/register', [App\Http\Controllers\API\Auth\AuthController::class, 'register'])->name('register');

//https://j8n.medium.com/laravel-implementing-social-auth-for-api-via-mobile-app-with-socialite-passport-30ff4a6fc4d
Route::get('social/login', [App\Http\Controllers\API\Auth\AuthController::class, 'socialLogin']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\Auth\AuthController::class, 'login'])->name('login');

//API route for deactivate user
Route::post('/deactivateAccount', [App\Http\Controllers\API\Auth\AuthController::class, 'deactivateAccount']);

//API route for deactivate user
Route::post('/changePassword', [App\Http\Controllers\API\Auth\AuthController::class, 'changePassword']);

//API route for view-user user // testing purpose only
//Route::post('/view-user', [App\Http\Controllers\API\Auth\AuthController::class, 'viewUser']);

// Logout route
Route::post('/logout', [App\Http\Controllers\API\Auth\AuthController::class, 'logout'])->middleware('auth:sanctum');

//Tell get users to use post
Route::get('/login', function(){
    return "<h2>Please use the API or Login!</h2>";
});

Route::get('retailers/featured', 'App\Http\Controllers\API\Retailer\RetailerController@featured');
Route::get('retailers/week', 'App\Http\Controllers\API\Retailer\RetailerController@week');
Route::get('retailers/lastMonth', 'App\Http\Controllers\API\Retailer\RetailerController@lastMonth');
Route::get('retailers/startswith/{letter}', 'App\Http\Controllers\API\Retailer\RetailerController@startsWith');
Route::get('retailers/autocomplete', 'App\Http\Controllers\API\Retailer\RetailerController@autocomplete');
Route::resource('retailers','App\Http\Controllers\API\Retailer\RetailerController',['only' => ['index','show']]);
Route::post('retailer/clickhistory','App\Http\Controllers\API\Retailer\RetailerController@updateHistory');

Route::resource('products','App\Http\Controllers\API\Product\ProductController',['only' => ['index']]);


Route::resource('retailers.coupons','App\Http\Controllers\API\Retailer\RetailerCouponController',['only' => ['index']]); //One to many
Route::resource('retailers.products','App\Http\Controllers\API\Retailer\RetailerProductController',['only' => ['index']]); //One to many

Route::resource('retailers.categories','App\Http\Controllers\API\Retailer\RetailerCategoryController',['only' => ['index']]); //Many to many

Route::get('category/{category}/subcategories','App\Http\Controllers\API\Category\CategoryRetailerController@subcategories');
Route::resource('category.retailers','App\Http\Controllers\API\Category\CategoryRetailerController',['only' => ['index']]); //Many to many
Route::get('category/{category}/products','App\Http\Controllers\API\Category\CategoryProductController@products');
//Nasir API's

Route::get('categories/featured','App\Http\Controllers\API\Retailer\RetailerCategoryController@getFeaturedCategoriesMobile');
Route::get('categories/parent','App\Http\Controllers\API\Retailer\RetailerCategoryController@getparentCategoriesMobile');
Route::get('store/subcategories/{categoryId}/all','App\Http\Controllers\API\Retailer\RetailerCategoryController@getRetailerSubcategories');

Route::resource('user','App\Http\Controllers\API\User\UserController',['only' => ['index','show','update','destroy']])->middleware('auth:sanctum');
Route::resource('user.transactions','App\Http\Controllers\API\User\UserTransactionController',['only' => ['index']])->middleware('auth:sanctum');
Route::resource('user.clicks','App\Http\Controllers\API\User\UserClickController',['only' => ['index']])->middleware('auth:sanctum');
Route::get('user/get/notifications','App\Http\Controllers\API\User\UserController@userNotifications')->middleware('auth:sanctum');
Route::post('user/delete-single/notifications/{id}','App\Http\Controllers\API\User\UserController@deleteSingleNotifications')->middleware('auth:sanctum');
Route::post('user/delete-all/notifications','App\Http\Controllers\API\User\UserController@deleteAllNotifications')->middleware('auth:sanctum');

Route::get('user/{user}/wishlist','App\Http\Controllers\API\User\UserFavoriteController@wishlist')->middleware('auth:sanctum');
Route::get('/get/user/balance','App\Http\Controllers\API\User\UserController@getUserTotalBalance')->middleware('auth:sanctum');
Route::get('/transaction/{transaction_id}','App\Http\Controllers\API\User\UserController@getTransactionDetails')->middleware('auth:sanctum');
Route::get('/transaction/history/all','App\Http\Controllers\API\User\UserController@getTransactionHistory')->middleware('auth:sanctum');
Route::get('/user/referal/all','App\Http\Controllers\API\User\UserController@getUserReferal')->middleware('auth:sanctum');
Route::get('/user/referal/get-all','App\Http\Controllers\API\User\UserReferralController@index')->middleware('auth:sanctum');
Route::post('/user/withdraw/request','App\Http\Controllers\API\User\UserController@userWithDrawRequest')->middleware('auth:sanctum');

Route::resource('user.favorites','App\Http\Controllers\API\User\UserFavoriteController',['only' => ['index']])->middleware('auth:sanctum');
Route::post('user/add/retailer-favorites','App\Http\Controllers\API\User\UserFavoriteController@addRetailerFavorites')->middleware('auth:sanctum');
Route::post('user/remove/retailer-favorites','App\Http\Controllers\API\User\UserFavoriteController@removeRetailerFavorites')->middleware('auth:sanctum');
//	Route::get('autocomplete', 'Search\SearchController@autocomplete')->name('autocomplete');
Route::get('/countries-list', 'App\Http\Controllers\API\Retailer\RetailerCategoryController@getCountriesList')->name('countries-list');
Route::get('/settings/not-recorded-purchase', 'App\Http\Controllers\API\Setting\SettingController@notRecordPurchase')->name('not-record-purchase');
Route::get('/settings/help-url', 'App\Http\Controllers\API\Setting\SettingController@getHelpURL')->name('help-url');
Route::get('/settings/forgot-url', 'App\Http\Controllers\API\Setting\SettingController@getForgotURL')->name('forgot-url');
Route::get('/settings/get-all', 'App\Http\Controllers\API\Setting\SettingController@appSettings')->name('settings-all');
