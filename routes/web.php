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

Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/login/facebook','Auth\LoginController@redirectToProviderFacebook');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallbackFacebook');
Route::get('logout', 'Auth\LoginController@logout');

//signup
Route::get('/signup', 'Auth\RegisterController@index');
Route::post('/signup', 'Auth\RegisterController@register');

Route::get('/vue', 'SpaController@index');


Route::group(['middleware' => 'auth'], function()
{
    //home
    Route::get('/', 'HomeController@index');
    Route::post('/filterDistance', 'HomeController@filterDistance');

    //profile-overview
    Route::get('/crossings', 'ProfileController@index');
    //other peoples profiles
    Route::get('/users/{user}', 'ProfileController@show');
    //my profile
    Route::get('/profile/edit','ProfileController@edit');
    Route::post('/users', 'ProfileController@sendFriendRequest');


    //conversation
    Route::post('/conversation', 'ConversationController@store');
    Route::get('/conversation/{conversation}', 'ConversationController@show');
    Route::post('/conversation/{conversation}', 'ConversationController@addChatToConversation');
    Route::get('/chat', 'ConversationController@index');

    //Locations
    Route::post('/location/getLocation','LocationController@getLocation');
    Route::post('/location/store','LocationController@store');
});
