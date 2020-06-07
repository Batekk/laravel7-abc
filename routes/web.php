<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@welcome')->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('/', ['as' => 'show', 'uses' => 'UserController@show']);
    Route::get('/add', ['as' => 'add', 'uses' => 'UserController@userCreate']);
    Route::post('/add', ['as' => 'add', 'uses' => 'UserController@userStore']);
    Route::get('{user_id}/edit', ['as' => 'edit', 'uses' => 'UserController@userEdit']);
    Route::get('{user_id}/update', ['as' => 'update', 'uses' => 'UserController@userUpdate']);
    Route::get('{user_id}/destroy', ['as' => 'destroy', 'uses' => 'UserController@userDestroy']);
});

//Route::group(['prefix' => 'company', 'as' => 'company.'], function () {
//    Route::get('/', ['as' => 'show', 'uses' => 'HomeController@company']);
//    Route::post('/add', ['as' => 'add', 'uses' => 'HomeController@companyAdd']);
//    Route::get('{company_id}/edit', ['as' => 'edit', 'uses' => 'HomeController@companyEdit']);
//    Route::post('{company_id}/edit', ['as' => 'update', 'uses' => 'HomeController@companyUpdate']);
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
