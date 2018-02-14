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

// Cria as rotas de autenticação no braço e em Português
Route::get('cadastro', [
  'as' => 'cadastro',
  'uses' => 'Auth\RegisterController@showRegistrationForm'
]);
Route::post('cadastro', [
  'as' => '',
  'uses' => 'Auth\RegisterController@register'
]);



Route::get('/home', 'HomeController@index')->name('home');

Route::get('/editar-cadastro', 'PessoaController@editarCadastro')->name('editarCadastro');
Route::post('/editar-cadastro', 'PessoaController@editaCadastro')->name('editaCadastro');


//Autor 
Route::get('/autor', 'AutorController@index')->name('autor');


// Administrador
Route::get('/administrador', 'AdminController@index')->name('administrador');

// Edicao
Route::get('/edicao/{id}', 'EdicaoController@edicao')->name('edicao');
Route::get('/edicao/cadastrar', 'EdicaoController@cadastroEdicao')->name('cadastroEdicao');

// Nivel
Route::get('/nivel/cadastrar', 'AdminController@cadastroNivel')->name('cadastroNivel');

// Area
Route::get('/administrador/cadastro/area', 'AdminController@cadastroArea')->name('cadastroArea');

// Escola
Route::get('/escola/cadastrar', 'AdminController@cadastroEscola')->name('cadastroEscola');
Route::post('/escola/cadastrar', 'AdminController@cadastraEscola')->name('cadastroEscola');
Route::get('/escola/{id}', 'AdminController@editarEscola')->name('escola');



Route::get('/administrador/usuarios', 'AdminController@administrarUsuarios')->name('administrarUsuarios');


//Organizador
Route::get('/organizador', 'OrganizadorController@index')->name('organizador');







//

Route::get('/cadastro/sucess', 'SucessoCadastroController@index')->name('cadastroSucesso');
//Route::get('/cadastro/homologacao', 'HomologacaoController@index')->name('cadastroFichaHomologacao');


//
Route::get('/avaliacao', function(){
    return view('avaliador')->withAreas(App\AreaConhecimento::all());
});


Route::resource('projeto', 'ProjetoController');

Route::prefix('projeto')->group(function () {
    Route::get('{projeto}/vincula-integrante', 'ProjetoController@showFormVinculaIntegrante')->name('projeto.formVinculaIntegrante');
    Route::post('vincula-integrante', 'ProjetoController@vinculaIntegrante')->name('projeto.vinculaIntegrante');
    //AJAX
    Route::get('{projeto}/vincula-integrante/{email}', 'ProjetoController@searchPessoaByEmail');
});

Route::get('/relatorio/{id}','ProjetoController@relatorio')->name('relatorio');

Route::get('/projeto/{id}/vinculaRevisor/', 'ProjetoController@showFormVinculaRevisor')->name('vinculaRevisor');
Route::post('/projeto/vinculaRevisor/', 'ProjetoController@vinculaRevisor')->name('vinculaRevisorPost');
//
Route::get('/projeto/{id}/vinculaAvaliador/', 'ProjetoController@showFormVinculaAvaliador')->name('vinculaAvaliador');
Route::post('/projeto/vinculaAvaliador/', 'ProjetoController@vinculaAvaliador')->name('vinculaAvaliadorPost');
//
Route::get('/projeto/{id}/setSituacao/{situacao}', 'ProjetoController@setSituacao')->name('projeto.setSituacao');
//AJAX
Route::prefix('nivel')->group(function () {
    Route::get('areasConhecimento/{id}', 'NivelController@areasConhecimento');
});

