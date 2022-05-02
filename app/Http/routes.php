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

Route::get('/', 'EmpBasicController@index');
Route::get('/emp/basic', 'EmpBasicController@basic');
Route::get('/emp/basic/data', 'EmpBasicController@basicData');
// 薪資
Route::get('/salary/index', 'SalaryController@index');
Route::get('/salary/index/data', 'SalaryController@indexData');
Route::post('/salary/update', 'SalaryController@update');
Route::post('/salary/insert', 'SalaryController@insert');
Route::post('/salary/destory', 'SalaryController@destory');

Route::post('/salary/trans', 'SalaryController@trans');

Route::get('/salary/pdf', 'SalaryController@pdf');


