<?php

//Auth::routes();
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@registerApi');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@loginApi');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
/*Route::prefix('/password')->group(function() {
    Route::get('/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/reset', 'Auth\ForgotPasswordController@reset');
    Route::get('/reset/{token}', 'Auth\ForgotPasswordController@showResetForm')->name('password.reset');
});*/

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('/message')->group(function() {
    Route::get('/', 'MessageController@index')->name('message');
    Route::get('/write', 'MessageController@write')->name('message.write');
    Route::post('/', 'MessageController@post')->name('message.post');
    Route::get('/hashtagSearch', 'MessageController@hashtagSearch')->name('message.hashtagSearch');
});

Route::prefix('/profile')->group(function() {
    Route::get('/', 'ProfileController@index')->name('profile');
    Route::get('/self', 'ProfileController@self')->name('profile.self');
    Route::get('/following', 'ProfileController@following')->name('profile.following');
    Route::get('/followers', 'ProfileController@followers')->name('profile.followers');
});

Route::post('/follow', 'ProfileController@follow')->name('follow');
Route::post('/unfollow', 'ProfileController@unfollow')->name('unfollow');