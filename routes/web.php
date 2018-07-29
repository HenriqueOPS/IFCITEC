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
use App\Http\Middleware;

Route::get('/version', function (){
	$strData = explode(':', file_get_contents('version.txt'));

	echo "Commit SHA: ".$strData[0]."<br />";
	echo "Pipeline ID: ".$strData[1];
});


//Gera os crachás

//Gera o
Route::get('/cracha/gerar-crachas', 'CrachaController@generateCrachas');
Route::get('/cracha/qr-code/{idPessoa}', 'CrachaController@generateQrCode');


Route::get('/', function () {
  if(Auth::check())
    return redirect()->route('home');

  return redirect()->route('login');
});

// API
Route::post('/api/login', 'ApiController@login');
Route::post('/api/registra-presenca', 'ApiController@registraPresenca');

Route::get('/api/projetos-avaliacao/{id}', 'ApiController@projetosAvaliacao');
Route::get('/api/campos-avaliacao/{id}', 'ApiController@camposAvaliacao');
Route::get('/api/salva-avaliacao/{id}', 'ApiController@salvaAvaliacao');


Auth::routes();
Route::post('/recuperar/senha/', 'Auth\ForgotPasswordController@emailSenha')->name('recuperar.senha');


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


Route::get('/debug', function (){
	return view('admin.debug');
});



//Edição dos dados pessoais
Route::get('/editar-cadastro/{id}', 'PessoaController@editarCadastro')->name('editarCadastro');
Route::post('/editar-cadastro/{id}', 'PessoaController@editaCadastro')->name('editaCadastro');

//Relatórios
//Route::get('/relatorio', 'ReportController@index')->name('relatorio');
Route::get('/relatorio/niveis', 'RelatorioController@niveis')->name('relatorioNivel');
Route::get('/relatorio/niveis/projetos/{id}', 'RelatorioController@nivelProjetos')->name('nivelProjetos');
Route::get('/relatorio/escolas', 'RelatorioController@escolas')->name('relatorioEscola');
Route::get('/relatorio/escolas/projetos/{id}', 'RelatorioController@escolaProjetos')->name('escolaProjetos');
Route::get('/relatorio/areas', 'RelatorioController@areas')->name('relatorioArea');
Route::get('/relatorio/areas/projetos/{id}', 'RelatorioController@areaProjetos')->name('areaProjetos');
Route::get('/relatorio/edicoes', 'RelatorioController@edicoes')->name('relatorioEdicao');
Route::get('/relatorio/funcoes/usuarios', 'RelatorioController@funcoesUsuarios')->name('relatorioFuncoesUsuarios');
Route::get('/relatorio/voluntario/tarefa', 'RelatorioController@voluntarioTarefa')->name('relatorioVoluntarioTarefa');
Route::get('/relatorio/tarefa/voluntarios/{id}', 'RelatorioController@tarefaVoluntarios')->name('tarefaVoluntarios');



//Autor
Route::get('/autor', 'AutorController@index')->name('autor');

//Organizador
Route::get('/organizador', 'OrganizadorController@index')->name('organizador');

/* Administrador Routes */
Route::group(['middleware' => ['IsAdministrador']], function () {


	Route::get('/administrador', 'AdminController@index')->name('administrador');

	Route::get('/gerenciar', 'AdminController@administrarUsuarios');
	Route::post('/gerenciar-usuario/{id}', 'AdminController@editaFuncaoUsuario')->name('editaFuncaoUsuario');
	Route::get('/gerenciar/usuario/{id}', 'AdminController@editarFuncaoUsuario')->name('editarFuncaoUsuario');
	Route::get('/pesquisa','AdminController@pesquisa');

	// Comissão Avaliadora
	Route::get('/comissao/homologar/{id}', 'ComissaoAvaliadoraController@homologarComissao')->name('homologarComissao');
	Route::post('/comissao/homologar/', 'ComissaoAvaliadoraController@homologaComissao')->name('homologaComissao');

	// Nivel
	Route::get('/nivel/cadastrar', 'AdminController@cadastroNivel')->name('cadastroNivel');
	Route::post('/nivel/cadastrar', 'AdminController@cadastraNivel')->name('cadastroNivel');
	Route::get('/nivel/editar/{id}', 'AdminController@editarNivel')->name('nivel');
	Route::post('/nivel/edita-nivel', 'AdminController@editaNivel')->name('editaNivel');

	Route::get('/nivel/dados-nivel/{id}', 'AdminController@dadosNivel'); //Ajax
	Route::get('/nivel/exclui-nivel/{id}/{s}', 'AdminController@excluiNivel'); //


	// Area
	Route::get('/area/cadastrar', 'AdminController@cadastroArea')->name('cadastroArea');
	Route::post('/area/cadastrar', 'AdminController@cadastraArea')->name('cadastroArea');
	Route::get('/area/editar/{id}', 'AdminController@editarArea')->name('area');
	Route::post('/area/edita-area', 'AdminController@editaArea')->name('editaArea');

	Route::get('/area/dados-area/{id}', 'AdminController@dadosArea'); //Ajax
	Route::get('/area/exclui-area/{id}/{s}', 'AdminController@excluiArea'); //Ajax


	// Edicao
	Route::get('/edicao/cadastrar', 'EdicaoController@cadastroEdicao')->name('cadastroEdicao');
	Route::post('/edicao/cadastrar', 'EdicaoController@cadastraEdicao')->name('cadastraEdicao');
	Route::get('/edicao/editar/{id}', 'EdicaoController@editarEdicao')->name('editarEdicao');
	Route::post('/edicao/edita-edicao', 'EdicaoController@editaEdicao')->name('edicao');

	Route::get('/edicao/dados-edicao/{id}', 'EdicaoController@dadosEdicao'); //Ajax
	Route::get('/edicao/exclui-edicao/{id}/{s}', 'EdicaoController@excluiEdicao'); //Ajax

	//Tarefa
	Route::get('/tarefa/cadastrar', 'AdminController@cadastroTarefa')->name('cadastroTarefa');
	Route::post('/tarefa/cadastrar', 'AdminController@cadastraTarefa')->name('cadastraTarefa');
	Route::get('/tarefa/editar/{id}', 'AdminController@editarTarefa')->name('tarefa');
	Route::post('/tarefa/edita-tarefa', 'AdminController@editaTarefa')->name('editaTarefa');

	Route::get('/tarefa/dados-tarefa/{id}', 'AdminController@dadosTarefa'); //Ajax
	Route::get('/tarefa/exclui-tarefa/{id}/{s}', 'AdminController@excluiTarefa'); //Ajax

	//Usuários
	Route::get('/usuario/exclui-usuario/{id}/{s}', 'AdminController@excluiUsuario'); //

});


/* Organização Routes */
Route::group(['middleware' => ['IsOrganizacao']], function () {

	// Escola
	Route::get('/escola/cadastrar', 'AdminController@cadastroEscola')->name('cadastroEscola');
	Route::post('/escola/cadastrar', 'AdminController@cadastraEscola')->name('cadastroEscola');
	Route::get('/escola/editar/{id}', 'AdminController@editarEscola')->name('escola');
	Route::post('/escola/edita-escola', 'AdminController@editaEscola')->name('editaEscola');
	Route::get('/escola/dados-escola/{id}', 'AdminController@dadosEscola'); //Ajax
	Route::get('/escola/exclui-escola/{id}/{s}', 'AdminController@excluiEscola'); //Ajax

});






// Avaliador/Revisor
Route::get('/avaliador', 'HomeController@homeAvaliador')->name('avaliador');
Route::get('/revisor', 'HomeController@homeRevisor')->name('revisor');

//Organizador
Route::get('/organizador', 'OrganizadorController@index')->name('organizador');

//Comissao Avaliadora
Route::get('/comissaoavaliadora', 'ComissaoAvaliadoraController@index')->name('comissao');
Route::get('/comissao/avaliadora', 'ComissaoAvaliadoraController@home')->name('comissaoHome');

//Voluntario
Route::get('/voluntario', 'VoluntarioController@index')->name('voluntario');
Route::get('/voluntario/cadastrar/{s}', 'VoluntarioController@cadastrarVoluntario')->name('cadastrarVoluntario'); //Ajax
Route::post('/voluntario/cadastra', 'VoluntarioController@cadastraVoluntario')->name('cadastraVoluntario');

Route::get('/administrador/usuarios', 'AdminController@administrarUsuarios')->name('administrarUsuarios');
Route::get('/periodo', 'PeriodosController@periodoInscricao');

Route::get('/inscricao-comissao-avaliadora', 'ComissaoAvaliadoraController@cadastrarComissao')->name('comissaoAvaliadora');
Route::post('/comissao/cadastrar', 'ComissaoAvaliadoraController@cadastraComissao')->name('cadastroAvaliador');
Route::get('/comissao/cadastrar/{s}', 'ComissaoAvaliadoraController@cadastrarComissao')->name('cadastraComissao'); //Ajax


Route::resource('projeto', 'ProjetoController');

Route::prefix('projeto')->group(function () {
    Route::post('vincula-integrante', 'ProjetoController@vinculaIntegrante')->name('projeto.vinculaIntegrante');
    //AJAX
    Route::get('vincula-integrante/{email}', 'ProjetoController@searchPessoaByEmail');

});
Route::prefix('projeto/editar')->group(function () {
    //AJAX
    Route::get('vincula-integrante/{email}', 'ProjetoController@searchPessoaByEmail');
    Route::get('nivel/areasConhecimento/{id}', 'NivelController@areasConhecimento'); //Ajax
});
Route::get('/projeto/editar/{id}', 'ProjetoController@editarProjeto')->name('editarProjeto');
Route::post('/projeto/edita-projeto', 'ProjetoController@editaProjeto')->name('editaProjeto');

//Route::get('/relatorio/{id}','ProjetoController@relatorio')->name('relatorio');

Route::get('/projeto/{id}/vinculaRevisor/', 'ProjetoController@showFormVinculaRevisor')->name('vinculaRevisor');
Route::post('/projeto/vinculaRevisor/', 'ProjetoController@vinculaRevisor')->name('vinculaRevisorPost');
//
Route::get('/projeto/{id}/vinculaAvaliador/', 'ProjetoController@showFormVinculaAvaliador')->name('vinculaAvaliador');
Route::post('/projeto/vinculaAvaliador/', 'ProjetoController@vinculaAvaliador')->name('vinculaAvaliadorPost');
//
Route::get('/projeto/{id}/setSituacao/{situacao}', 'ProjetoController@setSituacao')->name('projeto.setSituacao');

Route::get('projeto/nivel/areasConhecimento/{id}', 'NivelController@areasConhecimento'); //Ajax


//Emails
Route::get('mail/voluntario', function(){
    Mail::later(5,'mail.mailVoluntario', [Auth::user()->nome], function($message){
            $message->to(Auth::user()->email);
            $message->subject('IFCITEC');
    });

});
