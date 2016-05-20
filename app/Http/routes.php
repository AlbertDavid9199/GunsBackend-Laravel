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
    return view('welcome');
});


//
// DEBUG SQL
//
/*
Event::listen('illuminate.query',function($sql){
   var_dump($sql);
});
*/
//
//



Route::get('/data/load', 'DataLoaderController@load');

/*-------------------- geolocation Part -------------------*/
Route::get('/geolocation/bycity/{city}','GEOLocationController@byCity');
Route::get('/geolocation/bystate/{state}','GEOLocationController@byState');
Route::get('/geolocation/byzip/{zip}','GEOLocationController@byZip');
Route::get('/geolocation/byareacode/{aa}','GEOLocationController@byAreaCode');
Route::get('/geolocation/bycounty/{county}','GEOLocationController@byCounty');
Route::get('/geolocation/bylanlong/{lat}/{long}','GEOLocationController@byLanLong');
Route::get('/geolocation/nearzip/{zip}/{miles}','GEOLocationController@nearZip');
Route::get('/geolocation/nearareacode/{areacode}/{miles}','GEOLocationController@nearAreacode');
Route::get('/geolocation/near/{lat}/{long}/{miles}','GEOLocationController@near');

/*-------------------- User Authontication Part -------------------*/

Route::post('api/v1/justguns/login', 'UserController@authenticate');
Route::get('api/v1/justguns/logout', 'UserController@logout');
Route::get('api/v1/justguns/userupdate', 'UserController@editUser');
Route::post('api/v1/justguns/signup', 'UserController@postRegister');
Route::post('api/v1/justguns/userEdit', 'UserController@editUser');
Route::post('api/v1/justguns/forgetPassword', 'UserController@forgetPassword');

/*-------------------- User Authontication Part -------------------*/

Route::post('api/v1/justguns/product/save', 'ProductController@dataSave');
Route::post('api/v1/justguns/product/delete', 'ProductController@dataDelete');
Route::post('api/v1/justguns/product', 'ProductController@dataGetAll');
Route::post('api/v1/justguns/product/getbyid', 'ProductController@dataGetById');
Route::post('api/v1/justguns/product/updatebyid', 'ProductController@dataUpdateById');
Route::post('api/v1/justguns/product/publishbyid', 'ProductController@dataPublishById');