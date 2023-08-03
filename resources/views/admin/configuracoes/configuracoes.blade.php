@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<h2>Painel administrativo</h2>
		</div>

		@include('partials.admin.navbar')
	</div>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-12 main main-raised" >
                <div class="text-center">
                   <h2>Configurações</h2>
                </div>

                <div class="barrinha">
                    <ul class="nav nav-pills nav-pills-primary" role="tablist" style="margin-bottom: 30px">
                        <li>
                            <a id="1" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-symbols-outlined">image</i>
                                Imagens
                            </a>
                        </li>
                        <li>
                            <a id="2" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-symbols-outlined">palette</i>
                                Navbar
                            </a>
                        </li>
                        <li>
                            <a id="3" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-symbols-outlined">palette</i>
                                Avisos
                            </a>
                        </li>
                        <li>
                            <a id="4" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-symbols-outlined">palette</i>
                                Botões
                            </a>
                        </li>
                        <li>
                            <a id="5" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-symbols-outlined">format_size</i>
                                Fontes
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="forms">
                    <form id="1-form" class="formulario-configuracao" method="POST" action="{{ route('admin.background') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="iform">
                            <label for="image">Selecione a Imagem, deverá ser do tipo png</label>
                            <div class="imgform d-flex flex-column align-items-center">
                            <input type="file" id="formFile" name="image" class="form-control-file mx-auto"/>
                            </div>
                            <input type="radio" value="background" id="background-radio" name="imagem"/>
                            <label for="background-radio">Tela da Plataforma</label>
                            <input type="radio" value="teladelogin" id="teladelogin-radio" name="imagem"/>
                            <label for="teladelogin-radio">Tela de Login</label>
                            <input type="radio" value="ifcitecheader" id="ifcitecheader-radio" name="imagem"/>
                            <label for="ifcitecheader-radio">Cabeçalho dos relátorios</label>
                            <input type="radio" value="logo" id="logo-radio" name="imagem"/>
                            <label for="logo-radio">Logo da navbar</label>
                            <input type="radio" value="logonormal" id="logo-radio" name="imagem"/>
                            <label for="logo-radio">Logo da tela de login</label>
                            <input type="radio" value="Imagem" id="logo-radio" name="imagem"/>
                            <label for="logo-radio">Imagem para os emails</label><br>
                            <button type="submit" class="btn btn-primary" >mudar imagem</button>
                        </div>            
                    </form>
                    <form id="2-form" class="formulario-configuracao" method="POST" action="{{ route('admin.navbar')}}">
                    {{ csrf_field() }}
                        <label for="favcolor">Selecione a cor:</label>
                        <input type="color" id="favcolor" name="cor" value="#ff0000"><br><br>
                        <button type="submit" class="btn btn-primary"  >Mudar cor da NavBar</button><br><br>
                    </form>
                    <form id="3-form" class="formulario-configuracao" method="POST" action="{{ route('admin.avisos')}}">
                        {{ csrf_field() }}
                        <label for="favcolor">Selecione a cor:</label>
                        <input type="color" id="favcolor" name="cor" value="#ff0000"><br><br>
                        <button type="submit" class="btn btn-primary"  >Mudar cor dos avisos</button><br><br>
                    </form>
                    <form id="4-form" class="formulario-configuracao" method="POST" action="{{ route('admin.botoes')}}">
                        {{ csrf_field() }}
                        <label for="favcolor">Selecione a cor:</label>
                        <input type="color" id="favcolor" name="cor" value="#ff0000"><br><br>
                        <button type="submit" class="btn btn-primary"   >Mudar cor dos botoes</button><br><br>
                    </form>
                    <form id="5-form" class="formulario-configuracao" method="POST" action="{{ route('admin.fontes') }}">
                        {{ csrf_field() }}
                        <label for="fontSelect">Selecione a fonte:</label>
                        <select id="fontSelect" name="fonte">
                            <option value="Arial">Arial</option>
                            <option value="Verdana">Verdana</option>
                            <option value="Helvetica">Helvetica</option>
                            <option value="Times New Roman">Times New Roman</option>
                            <option value="Courier New">Courier New</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Comic Sans MS">Comic Sans MS</option>
                            <option value="Impact">Impact</option>
                            <option value="Tahoma">Tahoma</option>
                            <option value="Lucida Console">Lucida Console</option>
                            <option value="Palatino Linotype">Palatino Linotype</option>
                            <option value="Trebuchet MS">Trebuchet MS</option>
                            <!-- Adicione mais opções de fonte aqui, se necessário -->
                        </select><br><br>
                        <button type="submit" class="btn btn-primary">Mudar fonte do texto</button>
                    </form>
                </div>

            </div>
           
        </div>
    </div>
</div>
@endsection

@section('css')
    <style>
        .imgForm {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        }
        #formFile{
            text-align: center;
        }
        .forms{
            text-align: center;
        }
        .iform label{
            margin: 40px 20px 30px 0px;    
        }
        .barrinha{
            display: flex;
            justify-content: center;
        }
    </style>
@endsection


@section('js')
<script>
    document.getElementById('nav-configuracoes').classList.add('active');

    // Função para mostrar o formulário correspondente à opção clicada
    function mostrarFormulario(opcao) {
        $('.formulario-configuracao').hide();
        $('#' + opcao + '-form').show();
    }

    $(document).ready(function () {
        // Esconde todos os formulários de configuração no início
        $('.formulario-configuracao').hide();

        $('.tab-projetos').click(function (e) {
            var target = $(this)[0];

            // Mostra o formulário correspondente à opção clicada
            mostrarFormulario(target.id);
        });
    });
</script>

<script src="{{ asset('js/main.js') }}"></script>
@endsection

<div>
