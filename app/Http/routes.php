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

//home
Route::group(['namespace'=>'Home', 'middleware'=>'home'], function(){
	Route::get('/', ['as'=>'home', 'uses'=>'IndexController@index']);
	Route::get('/p{p}', ['uses'=>'IndexController@index'])->where('p', '\d+');
	Route::get('/{id}', ['as'=>'detail', 'uses'=>'BlogController@detail'])->where('id', '\d+');
	Route::get('/c/{cid}', ['as'=>'category', 'uses'=>'BlogController@listbycategory'])->where('cid', '\d+');
	Route::match(['get', 'post'], '/login', ['as'=>'login', 'uses'=>'UserController@login']);
	Route::match(['get', 'post'], '/reg', ['as'=>'reg', 'uses'=>'UserController@reg']);
	Route::get('/logout', ['as'=>'logout', 'uses'=>'UserController@logout']);

	Route::resource('comment', 'CommentController');
});

//xadmin
Route::group(['prefix'=>'xadmin', 'middleware'=>'admin', 'namespace'=>'Admin'], function() {
	Route::get('/', 'IndexController@dashboard');
	Route::get('/logout', 'IndexController@logout');
	Route::match(['get', 'post'], '/login', ['as'=>'admin.login', 'uses'=>'IndexController@login']);

	Route::controller('sys', 'SysController');

	Route::resource('auth', 'AuthController');
	Route::resource('xadmin', 'XadminController');
	Route::resource('blog', 'BlogController');
	Route::resource('blogcategory', 'BlogCategoryController');
});

//public
Route::get('image/captcha', ['as'=>'captcha', function() {
	return Captcha::create();	
}]);

//open
Route::group(['prefix'=>'open/qq'], function() {
	Route::get('/login', 'Open\QqController@login');
	Route::get('/callback', 'Open\QqController@callback');
});
Route::group(['prefix'=>'open/weibo'], function() {
	Route::get('/login', 'Open\WeiboController@login');
	Route::get('/callback', 'Open\WeiboController@callback');
});

//cli
Route::group(['prefix'=>'cli'], function() {
	Route::get('/spider/run/{fid}', 'Cli\SpiderController@run');
});
