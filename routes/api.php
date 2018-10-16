<?php

use Illuminate\Http\Request;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group([

    'middleware' => 'api',

], function ($router) {

    //Login
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::post('sendPasswordResetLink','ResetPasswordController@sendEmail');
    Route::post('resetPassword','ChangePasswordController@process');

    //Categories
    Route::get('categoriesName','Admin\CategoryController@CategoryName');
    //Categories -- resource
    Route::get('categories','Admin\CategoryController@index');
    Route::post('categories','Admin\CategoryController@store');
    Route::delete('categories/{id}','Admin\CategoryController@destroy');
    Route::post('categories/{id}','Admin\CategoryController@update');
    Route::get('categories/{id}','Admin\CategoryController@show');

    //Diseños busqueda individual 
    Route::get('workdesignCategory/{id}','Admin\WorkdesignController@workdesignCategory');
    Route::get('workdesignUsers/{id}','Admin\WorkdesignController@workdesignUsers');
    Route::get('workdesignTitle/{title}','Admin\WorkdesignController@workdesignTitle');
    Route::get('workdesignDependency/{dependency}','Admin\WorkdesignController@workdesignDependency');
    Route::get('workdesignStatus/{status}','Admin\WorkdesignController@workdesignStatus');
    //Diseños busqueda FILTRO
    Route::get('workdesignSearch','Admin\WorkdesignController@avancedSearch');
    //Diseños -- Resource
    Route::get('workdesigns','Admin\WorkdesignController@index');
    Route::delete('workdesigns/{id}','Admin\WorkdesignController@destroy');
    Route::post('workdesigns','Admin\WorkdesignController@store');
    Route::post('workdesigns/{id}','Admin\WorkdesignController@update');

    //Route::post('workdesignsFile/','Admin\WorkdesignController@storeFile');
    Route::post('workdesignsFile/{id?}','Admin\WorkdesignController@storeFile');

    //work
    Route::post('work','Admin\WorkController@store');
    Route::get('works/{id}','Admin\WorkController@index');
    Route::delete('work/{id}','Admin\WorkController@destroy');
    Route::get('workDownload/{id}','Admin\WorkController@download');

    //users
    Route::get('usersName','Admin\WorkdesignController@usersList');

});
