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
    return view('login');
})->name('login');

Route::get('/home', function() {
    return view('home');
});

Route::get('/login/facebook','Auth\LoginController@redirectToProviderFacebook');
Route::get('/login/twitter','Auth\LoginController@redirectToProviderTwitter');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallbackFacebook');
Route::get('login/twitter/callback', 'Auth\LoginController@handleProviderCallbackTwitter');
Route::get('logout', function(){
    Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
});


Route::group(['middleware' => 'auth'], function()
{
    Route::get('/home', function() {
        return view('home');
    });
});
