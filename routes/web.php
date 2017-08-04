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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//
Route::get('/avaliacao', function(){
    return view('avaliador');
});
//
Route::prefix('moodle')->group(function () {
    Route::get('login', 'Auth\MoodleAuthController@index')->name('moodleLogin');
    Route::post('login', 'Auth\MoodleAuthController@autenticar')->name('moodleLoginPost'); 
});

Route::resource('projeto', 'ProjetoController');

Route::prefix('projeto')->group(function () {
    Route::get('{projeto}/vincula-integrante', 'ProjetoController@showFormVinculaIntegrante')->name('projeto.formVinculaIntegrante');
    Route::post('vincula-integrante', 'ProjetoController@vinculaIntegrante')->name('projeto.vinculaIntegrante');
    //AJAX
    Route::get('{projeto}/vincula-integrante/{email}', 'ProjetoController@searchPessoaByEmail');
});

//AJAX
Route::prefix('nivel')->group(function () {
    Route::get('areasConhecimento/{id}', 'NivelController@areasConhecimento');
});