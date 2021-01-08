<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('index');

Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

Route::resources([
    'users' => 'UserController',
    'companies' => 'CompanyController',
    'category' => 'CategoryController',
    'services' => 'ServiceController'
]);

Route::post('users/{user}/login', ['as' => 'users.login', 'uses' => 'UserController@login']);

Auth::routes();
