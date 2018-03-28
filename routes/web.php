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

Route::get('/', 'Auth\LoginController@index')->name('login');

Route::get('/login/facebook','Auth\LoginController@redirectToProviderFacebook');
Route::get('/login/twitter','Auth\LoginController@redirectToProviderTwitter');
Route::get('/login/google','Auth\LoginController@redirectToProviderGoogle');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallbackFacebook');
Route::get('login/twitter/callback', 'Auth\LoginController@handleProviderCallbackTwitter');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallbackGoogle');
Route::get('logout', 'Auth\LoginController@logout');


Route::group(['middleware' => 'auth'], function()
{
    Route::get('/home', 'HomeController@index');

    //Locations
    Route::post('/location/getLocation','LocationController@getLocation');
    Route::post('/location/store','LocationController@store');
});
