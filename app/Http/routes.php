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

// 員工基本資料
Route::get('/emp/basic', 'EmpBasicController@basic');
Route::get('/emp/basic/data', 'EmpBasicController@basicData');

// 機台工作人員
Route::get('/emp/worker', 'EmpBasicController@worker');
Route::get('/emp/worker/data', 'EmpBasicController@workerData');

// 排程完工
Route::get('/arrdone/data', 'ArrDoneController@getData');

// 薪資
Route::get('/salary/index', 'SalaryController@index');
Route::get('/salary/index/data', 'SalaryController@indexData');

// 費用 view
Route::get('/expense', 'ExpenseController@index');
// 資料
Route::get('/expense/data', 'ExpenseController@data');

Route::post('/salary/update', 'SalaryController@update');
Route::post('/salary/insert', 'SalaryController@insert');
Route::post('/salary/destory', 'SalaryController@destory');
Route::post('/salary/destoryMonth', 'SalaryController@destoryMonth');

Route::post('/salary/trans', 'SalaryController@trans');

// 報表和圖表
Route::get('/salary/pdf/{y}', 'SalaryController@pdf');

Route::get('/user/{id}', function($id)
{
    // return $id;
    return view('salary/user',compact('id'));
    return 'abc';
    // if ($request->route('id'))
    // {
    //     //
    // }
});


Route::get('/salary/chart', 'SalaryController@chart');


