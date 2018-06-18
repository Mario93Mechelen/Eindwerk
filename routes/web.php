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
Route::get('/login/facebook/callback', 'Auth\LoginController@handleProviderCallbackFacebook');
Route::get('/logout', 'Auth\LoginController@logout');

//signup
Route::get('/signup', 'Auth\RegisterController@index');
Route::post('/signup', 'Auth\RegisterController@register');
Route::get('/signup/confirm/{token}', 'Auth\LoginController@confirmemail');

Route::get('/vue', 'SpaController@index');


Route::group(['middleware' => 'auth'], function()
{
    //connect
    Route::get('/login/twitter','SettingController@redirectToProviderTwitter');
    Route::get('/login/twitter/callback', 'SettingController@handleProviderCallbackTwitter');

    Route::get('/login/instagram','SettingController@redirectToProviderInstagram');
    Route::get('/login/callback/instagram', 'SettingController@handleProviderCallbackInstagram');

    //home
    Route::get('/', 'HomeController@index');
    Route::post('/filterDistance', 'HomeController@filterDistance');

    //profile-overview
    Route::get('/crossings', 'ProfileController@index');
    Route::post('updateCover','ProfileController@updateCover');
    Route::post('/updateProfilepic','ProfileController@updateProfilepic');
    Route::post('/updateProfile', 'ProfileController@updateProfile');
    //other peoples profiles
    Route::get('/users/{user}', 'ProfileController@show');
    //my profile
    Route::get('/profile/edit','ProfileController@edit');
    Route::get('/profile/settings','ProfileController@settings');
    Route::post('/users', 'ProfileController@sendFriendRequest');
    Route::post('/updateEmail', 'SettingController@updateEmail');
    Route::post('/updateEmailNotifications', 'SettingController@updateEmailNotifications');
    Route::post('/updatePassword', 'SettingController@updatePassword');
    Route::post('/updateDistance', 'SettingController@updateDistance');
    Route::post('/deletelife', 'SettingController@deleteAllInfo');
    Route::post('/disconnectSocialMedia', 'SettingController@disconnectSocialMedia');
    Route::get('/getPhotos/instagram','ProfileController@getInstagramPhotos');
    Route::post('/photos/store/{type}/{id}', 'PhotoController@store');
    Route::post('/photo/delete', 'PhotoController@deletePhoto');
    Route::post('/updateInterests', 'ProfileController@updateInterests');

    //friends
    Route::get('/friends','FriendController@index');
    Route::post('/friends/accept','FriendController@accept');
    Route::post('/friends/deleteRequest', 'FriendController@deleteRequest');

    //conversation
    Route::post('/conversation', 'ConversationController@store');
    Route::get('/conversation/{conversation}', 'ConversationController@show');
    Route::post('/sendchat', 'ConversationController@addChatToConversation');
    Route::get('/chat', 'ConversationController@index');
    Route::post('/profile/conversation','ConversationController@createChatFromProfile');
    Route::post('/getConversation','ConversationController@getConversation');
    Route::post('/updateSeenStatus', 'ConversationController@updateSeenStatus');

    //feeds
    Route::post('/postcomment', 'ProfileController@postComment');
    Route::post('/addPost', 'ProfileController@addPost');

    //blocked
    Route::post('/blockUser', 'ProfileController@blockUser');
    Route::post('/deleteBlockedUser', 'ProfileController@deleteBlockedUser');

    //Locations
    Route::post('/location/getLocation','LocationController@getLocation');
    Route::post('/location/store','LocationController@store');

    //school
    Route::get('/school','ProfileController@school');
});
