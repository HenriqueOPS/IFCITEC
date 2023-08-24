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
use App\Jobs\MailBaseJob;
use App\Pessoa;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/version', function () {
	$strData = explode(':', file_get_contents('version.txt'));

	echo "Commit SHA: " . $strData[0] . "<br />";
	echo "Pipeline ID: " . $strData[1];
});

Route::get('/', function () {
	if (Auth::check())
		return redirect()->route('home');

	return redirect()->route('login');
})->name('ifcitec.home');

Route::post('/auth/verificacao', 'Auth\\LoginController@authenticate')->name('login.verification');
Route::get('/auth/confirmar/{idPessoa}', 'Auth\\LoginController@validarUsuario')->name('auth.validar.usuario');
Route::get('/auth/enviar/email/{idPessoa}', 'Auth\\LoginController@enviarEmailValidacao')->name('auth.enviar.email');

// API Routes
Route::any('/api/registra-presenca', 'ApiController@registraPresenca');

Route::post('/api/presenca', 'ApiController@presenca')->name('presenca-sistema');

Route::post('/api/salva-homologacao/', 'ApiController@salvaHomologacao');
Route::post('/api/salva-avaliacao/', 'ApiController@salvaAvaliacao');

Route::post('/recuperar/senha/', 'Auth\ForgotPasswordController@emailSenha')->name('recuperar.senha');

// Cria as rotas de cadastro no braço
Route::get('cadastro', [
	'as' => 'cadastro',
	'uses' => 'Auth\RegisterController@showRegistrationForm'
]);
Route::post('cadastro', [
	'as' => '',
	'uses' => 'Auth\RegisterController@register'
])->name('register');

// Authenticated Routes
Auth::routes();
Route::get('projeto/create','ProjetoController@create')->name('projeto.novo');
Route::get('/email/presenca/confirmada/{id}', 'ProjetoController@confirmaPresenca')->name('confirmaPresenca');

Route::group(['middleware' => ['IsVerificado']], function () {
	// Dashboard
	Route::get('/dashboard', 'DashboardController@dashboardPage');
	Route::get('/dashboard/data', 'DashboardController@dashboard'); // Ajax

	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/debug', function () {
		if (Auth::check())
			return view('admin.debug');

		return redirect()->route('login');
	});

	// Editar dados pessoais
	Route::get('/editar-cadastro/', 'PessoaController@editarCadastro')->name('editarCadastro');
	Route::post('/editar-cadastro/', 'PessoaController@editaCadastro')->name('editaCadastro');
	Route::post('/lgpdaceito/{id}','PessoaController@lgpdaceito')->name('lgpdaceito');
	// Autor
	Route::get('/autor', 'AutorController@index')->name('autor');
	Route::get('/autor/notarevisao/{id}','AutorController@nota')->name('notaProjeto');
	//Comissao Avaliadora
	Route::get('/comissao-avaliadora', 'ComissaoAvaliadoraController@index')->name('comissao');

	//Inscrição Comissão Avaliadora
	Route::get('/inscricao-comissao-avaliadora', 'ComissaoAvaliadoraController@cadastrarComissao')->name('comissaoAvaliadora');
	Route::post('/comissao/cadastrar', 'ComissaoAvaliadoraController@cadastraComissao')->name('cadastroAvaliador');

	//Voluntario
	Route::get('/voluntario', 'VoluntarioController@index')->name('voluntario');
	Route::get('/voluntario/cadastrar/{s}', 'VoluntarioController@cadastrarVoluntario')->name('cadastrarVoluntario'); //Ajax
	Route::post('/voluntario/cadastra', 'VoluntarioController@cadastraVoluntario')->name('cadastraVoluntario');

	Route::resource('projeto', 'ProjetoController');

	Route::get('projeto/nivel/dados-nivel/{id}', 'ProjetoController@dadosNivel'); //Ajax

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

	Route::get('projeto/nivel/areasConhecimento/{id}', 'NivelController@areasConhecimento'); //Ajax

	// Formulário de Avaliação/Homologação
	Route::get('/formulario/{tipo}/{id}', 'FormularioController@index')->name('formularioAvaliacao');
	Route::post('/formulario', 'FormularioController@store')->name('enviarFormulario');
});

/* Rotas Administrador */
Route::group(['middleware' => ['IsAdministrador', 'IsVerificado']], function () {

	Route::get('/gerenciar', 'AdminController@administrarUsuarios');
	Route::post('/gerenciar-usuario/{id}', 'AdminController@editaFuncaoUsuario')->name('editaFuncaoUsuario');
	Route::get('/gerenciar/usuario/{id}', 'AdminController@editarFuncaoUsuario')->name('editarFuncaoUsuario');
	Route::get('/pesquisa', 'AdminController@pesquisa');

	// Comissão Avaliadora
	Route::get('/comissao/homologar/{id}', 'ComissaoAvaliadoraController@homologarComissao')->name('homologarComissao');
	Route::post('/comissao/homologar/', 'ComissaoAvaliadoraController@homologaComissao')->name('homologaComissao');
	Route::get('/comissao/excluir/{idC}/{idF}/{s}', 'ComissaoAvaliadoraController@excluiComissao');

	// Escola
	Route::get('/escola/cadastrar', 'AdminController@cadastroEscola')->name('cadastroEscola');
	Route::post('/escola/cadastrar', 'AdminController@cadastraEscola')->name('cadastroEscola');
	Route::get('/escola/editar/{id}', 'AdminController@editarEscola')->name('escola');
	Route::post('/escola/edita-escola', 'AdminController@editaEscola')->name('editaEscola');
	Route::get('/escola/exclui-escola/{id}/{s}', 'AdminController@excluiEscola'); //Ajax
	// Empresa

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

	// Tarefa
	Route::get('/tarefa/cadastrar', 'AdminController@cadastroTarefa')->name('cadastroTarefa');
	Route::post('/tarefa/cadastrar', 'AdminController@cadastraTarefa')->name('cadastraTarefa');
	Route::get('/tarefa/editar/{id}', 'AdminController@editarTarefa')->name('tarefa');
	Route::post('/tarefa/edita-tarefa', 'AdminController@editaTarefa')->name('editaTarefa');
	Route::get('/tarefa/dados-tarefa/{id}', 'AdminController@dadosTarefa'); //Ajax
	Route::get('/tarefa/exclui-tarefa/{id}/{s}', 'AdminController@excluiTarefa'); //Ajax

	// Usuários
	Route::get('/usuario/exclui-usuario/{id}/{s}', 'AdminController@excluiUsuario');
	Route::get('/usuario/oculta-usuario/{id}', 'AdminController@ocultarUsuario')->name('ocultarUsuario');

	// Edição dos dados de usuario
	Route::get('/usuario/{id}/editar/', 'PessoaController@editarUsuario')->name('editarUsuario');
	Route::post('/usuario/{id}/editar-cadastro/', 'PessoaController@editaUsuario')->name('editaUsuario');

	// Vincula Homologador
	Route::get('/projeto/{id}/vinculaHomologador/', 'ProjetoController@showFormVinculaHomologador')->name('vinculaRevisor');
	Route::post('/projeto/vinculaHomologador/', 'ProjetoController@vinculaHomologador')->name('vinculaRevisorPost');
	// Vincula Avaliador
	Route::get('/projeto/{id}/vinculaAvaliador/', 'ProjetoController@showFormVinculaAvaliador')->name('vinculaAvaliador');
	Route::post('/projeto/vinculaAvaliador/', 'ProjetoController@vinculaAvaliador')->name('vinculaAvaliadorPost');

	// Fichas de Avaliação/Homologação
	Route::get('/administrador/fichas', 'FichaController@index')->name('administrador.ficha');
	Route::get('/administrador/fichas/cadastrar', 'FichaController@create')->name('adminstrador.cadastrarFicha');
	Route::post('/administrador/fichas/cadastrar', 'FichaController@store')->name('adminstrador.salvarFicha');
	Route::get('/administrador/fichas/copiar', 'FichaController@copiarFicha')->name('adminstrador.copiarFicha');
	Route::post('/administrador/fichas/copiar', 'FichaController@copiaFicha')->name('adminstrador.copiaFicha');
	Route::get('/ocultar-pessoa', 'AdminController@ocultarPessoa')->name('pessoa.ocultar');
	Route::get('/administrador/fichas/{id}', 'FichaController@show')->name('administrador.showFicha');
	Route::get('/administrador/fichas/{id}/editar', 'FichaController@edit')->name('administrador.edit');
	Route::post('/administrador/fichas/editar', 'FichaController@update')->name('administrador.alteraFicha');
	Route::post('/ocultarusuario-admin/{id}','AdminController@ocultar')->name('administrador.ocultar');

	// Administrador
	Route::get('/emails-enviados', 'GerenMsgController@tabela')->name('emails-enviados');
	Route::post('/administrador/navbar',"AdminController@navbar")->name('admin.navbar');
	Route::post('/administrador/cor_botoes',"AdminController@corBotoes")->name('admin.botoes');
	Route::post('/administrador/fontes',"AdminController@fontes")->name('admin.fontes');
	Route::post('/administrador/cor_avisos',"AdminController@cordosavisos")->name('admin.avisos');
	Route::post('/administrador/upload','MediaController@background')->name('admin.background');
	Route::get('/administrador/configuracoes','AdminController@configuracoes')->name('admin.configuracoes');
	Route::get('/administrador/empresas','AdminController@empresas')->name('admin.empresas');
	Route::get('/administrador/empresas/nova','AdminController@NovaEmpresa')->name('admin.empresas.nova');
	Route::post('/administrador/empresas/cadastrar','AdminController@cadastroEmpresa')->name('admin.empresas.cadastrar');
	Route::get('/editar/empresa/{id}','AdminController@editarempresa')->name('admin.empresas.editar');
	Route::post('/editar/empresa/editar','AdminController@editaEmpresa')->name('editaEmpresa');
	Route::get('/administrador/brindes','AdminController@brindes')->name('admin.brindes');
	Route::get('/administrador/brindes/novo','AdminController@NovoBrinde')->name('admin.brindes.novo');
	Route::post('/admin/premiacao/aumento', 'AdminController@adicionarQuantidade')->name('admin.premiacao.aumento');
	Route::post('/admin/premiacao/decremento', 'AdminController@decrementarQuantidade')->name('admin.premiacao.decremento');
	Route::post('/administrador/brinde/cadastrar','AdminController@cadastroBrinde')->name('admin.brindes.cadastrar');
	Route::get('/projetos/homologar-projetos', 'ProjetoController@homologarProjetos')->name('homologar-projetos');
	Route::post('/projetos/homologa-projetos', 'ProjetoController@homologaProjetos')->name('homologa-projetos');
	Route::get('/projeto/nao-compareceu/{id}/{s}', 'ProjetoController@projetoNaoCompareceu'); //
	Route::get('/projeto/compareceu/avaliado/{id}/{s}', 'ProjetoController@projetoCompareceuAvaliado');
	Route::get('/projeto/compareceu/nao-avaliado/{id}/{s}', 'ProjetoController@projetoCompareceuNaoAvaliado');
	Route::get('/empresa/dados-empresa/{id}', 'AdminController@dadosEmpresa'); 
	Route::get('/brinde/dados-brinde/{id}', 'AdminController@dadosBrinde')->name('brinde.dados');
	Route::get('/admin/brindes/editar/{id}', 'AdminController@editarbrindes')->name('admin.brindes.editar');
	Route::post('/edita-brinde', 'AdminController@editaBrinde')->name('editaBrinde');
	Route::get('/administrador', 'AdminController@index')->name('administrador');
	Route::get('/administrador/projetos', 'AdminController@projetos')->name('administrador.projetos');
	Route::get('/administrador/escolas', 'AdminController@escolas')->name('administrador.escolas');
	Route::get('/administrador/areas', 'AdminController@areasPorNiveis')->name('administrador.areas');
	Route::get('/administrador/areas/excluir/{id}', 'AdminController@excluiArea')->name('administrador.areas.excluir');
	Route::get('/administrador/tarefas', 'AdminController@tarefas')->name('administrador.tarefas');
	Route::get('/administrador/usuario', 'AdminController@usuarios')->name('administrador.usuarios');
	Route::get('/administrador/comissao', 'AdminController@comissao')->name('administrador.comissao');
	Route::get('/administrador/notas', 'AdminController@notas')->name('administrador.notas');

	Route::get('/administrador/relatorios/{edicao?}', 'AdminController@relatorios')->name('administrador.relatorios');
	Route::get('/administrador/escolhe-edicao/relatorios', 'AdminController@relatoriosEdicao')->name('administrador.relatoriosEdicao');
	Route::post('/administrador/escolhe-edicao/relatorios', 'AdminController@relatoriosEscolheEdicao')->name('administrador.escolheEdicao');
	Route::get('/movimento-registros/{id}', 'AdminController@showRegistros')->name('movimento-registros.show');

	// Dashboard
	Route::get('/administrador/dashboard', 'AdminController@dashboardPage')->name('dashboard');
	Route::get('/administrador/dashboard/data', 'AdminController@dashboard'); // Ajax
	Route::get('/administrador/dashboard/projetos', 'AdminController@dashboardNaoAvaliados'); // Ajax
	Route::get('/administrador/dashboard/avaliadores', 'AdminController@dashboardAvaliadoresNaoPresentes'); // Ajax

	// Cadastro de mensagens
	Route::get('/administrador/mensagens', 'GerenMsgController@index')->name('gerenciadorMensagens');
	Route::get('/administrador/mensagens/get/{tipo}', 'GerenMsgController@fetchByType')->name('mensagens.fetchByType'); // Ajax
	Route::post('/mensagens/salvar', 'GerenMsgController@save')->name('mensagens.save'); // Ajax
	Route::post('/mensagens/enviar','GerenMsgController@enviar')->name('mensagens.enviar');
	Route::post('/administrador/mensagens/create/{nome}/{tipo}', 'GerenMsgController@create')->name('mensagens.create'); // Ajax
	Route::post('/administrador/mensagens/deletar/{id}', 'GerenMsgController@delete')->name('mensagens.delete'); // Ajax

	// TODO: refatorar
	Route::get('/administrador/nota-revisao/projeto/{projeto}', 'AdminController@notaRevisao')->name('notaRevisao');
	Route::get('/administrador/nota-avaliacao/projeto/{projeto}', 'AdminController@notaAvaliacao')->name('notaAvaliacao');
	Route::post('/administrador/muda/nota-revisao/projeto', 'AdminController@mudaNotaRevisao')->name('mudaNotaRevisao');
	Route::post('/administrador/muda/nota-avaliacao/projeto', 'AdminController@mudaNotaAvaliacao')->name('mudaNotaAvaliacao');
	Route::get('/administrador/cursos','AdminController@Cursos')->name('admin.cursos');
	Route::get('/administrador/cursos/create','AdminController@CriarCursos')->name('admin.cursos.criar');
	Route::post('/administrador/cursos/create','AdminController@CreateCurso')->name('admin.cursos.create');
	require_once "webRoutes/reportRoutes.php";


	// mostra os erros do arquivo laravel.log
	Route::get('/errors', function () {
		return view('admin.errors');
	});
});


/* Rotas Organização */
Route::group(['middleware' => ['IsOrganizacao']], function () {

	Route::get('/organizador', 'OrganizadorController@index')->name('organizador');

	// Escola
	Route::get('/escola/dados-escola/{id}', 'AdminController@dadosEscola'); //Ajax

	// Projeto
	Route::get('/organizador/projetos', 'OrganizadorController@projetos')->name('organizacao.projetos');
	Route::get('/projeto/{id}/status/', 'ProjetoController@statusProjeto')->name('statusProjeto'); //Ajax

	// Presença
	Route::get('/organizador/presenca', 'OrganizadorController@presenca')->name('organizacao.presenca');

	// Usuarios
	Route::get('/organizador/usuarios', 'OrganizadorController@usuarios')->name('organizacao.usuarios');
});


//Emails
Route::get('mail/voluntario', function () {

	Mail::later(5, 'mail.voluntario', [Auth::user()->nome], function ($message) {
		$message->to(Auth::user()->email);
		$message->subject('IFCITEC');
	});
});
