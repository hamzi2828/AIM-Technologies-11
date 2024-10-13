<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

//API route for login user
Route::get('/login', function(){
    return "<h2>Please use the API</h2>";
});

//API route for login user
Route::post('/login', function(){
    return json_encode(['message' => 'Please use the API']);
});