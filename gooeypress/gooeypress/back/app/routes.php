<?php

Event::listen('illuminate.query', function($sql){
    Log::info($sql);
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/worker', function(){
    Queue::push('Gooeypress\Workers\ExecWorker', []);
});

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/themes/', ['as' => 'themes.index', 'uses' => 'ThemeController@themes']);

Route::group(['prefix' => 'themes', 'before' => 'auth'], function(){
    Route::get('/save/{id}', 'ThemeController@saveTheme');
    Route::get('/remove/{id}', 'ThemeController@removeTheme');
});


Route::post('/api/yslow/{id}', 'APIController@yslow');
Route::post('/adverts/notify/paypal', 'AdvertsController@paypalIPN');

Route::group(['prefix' => 'account'], function(){
    Route::get('/logout', 'AccountController@logout');
    Route::get('/login', 'AccountController@showLoginForm');
    Route::post('/login', 'AccountController@doLogin');
    Route::get('/hash', 'AccountController@encryptString');

    Route::get('/signup', 'AccountController@showSignupForm');
    Route::post('/signup', 'AccountController@doSignup');

});

Route::group(['prefix' => 'account', 'before' => 'auth'], function(){
    Route::get('/profile', 'AccountController@profile');
    Route::post('/profile', 'AccountController@doProfile');

    Route::get('/change-password', 'AccountController@changePassword');
    Route::post('/change-password', 'AccountController@doChangePassword');

    Route::get('/email-preference', 'AccountController@emailPreference');
    Route::post('/email-preference', 'AccountController@doEmailPreference');

    Route::get('/themes', 'AccountController@savedThemes');
    Route::get('/stream', 'AccountController@activityStream');
});


Route::group(['prefix' => 'adverts', 'before' => 'auth'], function(){
    Route::get('dashboard', 'AdvertsController@dashboard');
    Route::get('choose', 'AdvertsController@choose');
    Route::get('create/{type}', 'AdvertsController@create');
    Route::get('show/{id}', 'AdvertsController@show');

    Route::post('create/{type}', 'AdvertsController@create');
    Route::post('store', 'AdvertsController@store');

    Route::get('orders', 'AdvertsController@orders');

});

Route::group(array('before' => 'auth'), function(){
    Route::post('theme/{hash}/rating', 'ThemeController@addThemeRating');
    Route::get('theme/{hash}/like', 'ThemeController@likeTheme');
});
Route::get('/theme/{hash}/{title}', 'ThemeController@themeDetails');

Route::get('demo/{hash}', ['as' => 'themes.demo', 'uses' => 'ThemeController@demo']);

Route::group(array('before' => 'auth.admin', 'prefix' => 'adm'), function(){
    Route::get('theme/new', 'AdmController@showAddThemeForm');
    Route::post('theme/new', 'AdmController@doAddTheme');
    Route::get('theme/list', 'AdmController@themeList');

    Route::get('theme/{id}', 'AdmController@showEditThemeForm');
    Route::post('theme/{id}', 'AdmController@doUpdateTheme');

    Route::get('theme/{id}/delete', 'AdmController@deleteTheme');

    /* API */
    Route::get('api/vendors', 'AdmController@vendors');
    Route::post('api/vendors', 'AdmController@doAddVendor');
    Route::get('api/authors', 'AdmController@authors');
    Route::post('api/authors', 'AdmController@doAddAuthor');
    Route::get('api/requirements', 'AdmController@requirements');
    Route::post('api/requirements', 'AdmController@doAddRequirement');
    Route::get('api/layouts', 'AdmController@layouts');
    Route::post('api/layouts', 'AdmController@doAddLayout');

    Route::get('api/styles', 'AdmController@styles');
    Route::post('api/styles', 'AdmController@doAddStyle');
    Route::get('api/genres', 'AdmController@genres');
    Route::post('api/genres', 'AdmController@doAddGenre');

    Route::get('api/platforms', 'AdmController@platforms');
    Route::post('api/platforms', 'AdmController@doAddPlatform');

    Route::get('api/licences', 'AdmController@licences');
    Route::post('api/licences', 'AdmController@doAddLicence');
});
