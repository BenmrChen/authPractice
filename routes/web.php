<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sign-in', function(){
    $input = request()->all();  // 取得input
    $user_name = $input['user_name'];
    session()->put('user_name', $user_name);
//    dd(session('user_name'));
    return redirect('/featureA');
});
Route::get('/featureA', 'authPracticeController@featureA');
