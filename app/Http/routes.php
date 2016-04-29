<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('/apistatus');
});


Route::get('apistatus', 'siteController@index')->name('apistatus')->middleware('jwt.auth.verify');


/*Route::group(['prefix' => 'api'], function () {

    # Handerrs
    Route::get('{userId}', 'Handerr\Handerrs\Controllers\HanderrController@show');
    Route::post('{userId}', 'Handerr\Handerrs\Controllers\HanderrController@store')->middleware('jwt.auth.user');
    Route::put('{userId}', 'Handerr\Handerrs\Controllers\HanderrController@update')->middleware('jwt.auth.user');

    # Services
    Route::post('{userId}/services', 'Handerr\Handerrs\Controllers\ServiceController@store')->middleware('jwt.auth.user');
    Route::get('{userId}/services', 'Handerr\Handerrs\Controllers\ServiceController@index');
    Route::get('{userId}/services/{serviceId}', 'Handerr\Handerrs\Controllers\ServiceController@show');
    Route::delete('{userId}/services/{serviceId}', 'Handerr\Handerrs\Controllers\ServiceController@destroy')->middleware('jwt.auth.user');
    Route::put('{userId}/services/{serviceId}', 'Handerr\Handerrs\Controllers\ServiceController@update')->middleware('jwt.auth.user');

    # Categories
    Route::get('categories', 'Handerr\Handerrs\Controllers\CategoryController@index');

});*/

/*

Route::get('/', function () {
    return redirect('/auth/login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('admin/users', 'Admin\\UsersController');
    Route::put('admin/apiusers/{id}/restore', 'Admin\ApiUsersController@restore')->name('admin.apiusers.restore');
    Route::resource('admin/apiusers', 'Admin\\ApiUsersController');
});

*/