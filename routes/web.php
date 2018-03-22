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
  if(Auth::check())
    return redirect()->route('home');

  return redirect()->route('login');
});

Auth::routes();

// Cria as rotas de cadastro no braço e em Português
Route::get('cadastro', [
  'as' => 'cadastro',
  'uses' => 'Auth\RegisterController@showRegistrationForm'
]);
Route::post('cadastro', [
  'as' => '',
  'uses' => 'Auth\RegisterController@register'
]);

Route::get('/home', 'HomeController@index')->name('home');

//Edição dos dados pessoais
Route::get('/editar-cadastro', 'PessoaController@editarCadastro')->name('editarCadastro');
Route::post('/editar-cadastro', 'PessoaController@editaCadastro')->name('editaCadastro');

// Escola
Route::get('/escola/cadastrar', 'AdminController@cadastroEscola')->name('cadastroEscola');
Route::post('/escola/cadastrar', 'AdminController@cadastraEscola')->name('cadastroEscola');
Route::get('/escola/editar/{id}', 'AdminController@editarEscola')->name('escola');
Route::post('/escola/edita-escola', 'AdminController@editaEscola')->name('editaEscola');


Route::get('/escola/dados-escola/{id}', 'AdminController@dadosEscola'); //Ajax
Route::get('/escola/exclui-escola/{id}/{s}', 'AdminController@excluiEscola'); //Ajax



//Autor 
Route::get('/autor', 'AutorController@index')->name('autor');


// Administrador
Route::get('/administrador', 'AdminController@index')->name('administrador');

// Edicao
Route::get('/edicao/cadastrar', 'EdicaoController@cadastroEdicao')->name('cadastroEdicao');
Route::post('/edicao/cadastrar', 'EdicaoController@cadastraEdicao')->name('cadastraEdicao');
Route::get('/edicao/editar/{id}', 'EdicaoController@editarEdicao')->name('editarEdicao');
Route::get('/edicao/{id}', 'EdicaoController@edicao')->name('edicao');


// Nivel
Route::get('/nivel/cadastrar', 'AdminController@cadastroNivel')->name('cadastroNivel');
Route::post('/nivel/cadastrar', 'AdminController@cadastraNivel')->name('cadastroNivel');
Route::get('/nivel/editar/{id}', 'AdminController@editarNivel')->name('nivel');
Route::post('/nivel/edita-nivel', 'AdminController@editaNivel')->name('editaNivel');
Route::get('/nivel/dados-nivel/{id}', 'AdminController@dadosNivel'); //Ajax
Route::get('/nivel/exclui-nivel/{id}/{s}', 'AdminController@excluiNivel'); //Ajax

// Area
Route::get('/area/cadastrar', 'AdminController@cadastroArea')->name('cadastroArea');
Route::post('/area/cadastrar', 'AdminController@cadastraArea')->name('cadastroArea');
Route::get('/area/editar/{id}', 'AdminController@editarArea')->name('area');
Route::post('/area/edita-area', 'AdminController@editaArea')->name('editaArea');
Route::get('/area/dados-area/{id}', 'AdminController@dadosArea'); //Ajax


// Avaliador/Revisor
Route::get('/avaliador', 'HomeController@homeAvaliador')->name('avaliador');
Route::get('/revisor', 'HomeController@homeRevisor')->name('revisor');

//Organizador
Route::get('/organizador', 'OrganizadorController@index')->name('organizador');


Route::get('/administrador/usuarios', 'AdminController@administrarUsuarios')->name('administrarUsuarios');






//Route::get('/cadastro/homologacao', 'HomologacaoController@index')->name('cadastroFichaHomologacao');


//
Route::get('/inscricao-comissao-avaliadora', function(){
    return view('cadastroAvaliador')->withAreas(App\AreaConhecimento::all());
})->name('comissaoAvaliadora');


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

