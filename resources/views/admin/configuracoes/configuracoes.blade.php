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
                
                <div>
                    <form method="POST" action="{{ route('admin.background') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                    <label for="image">Selecione a Imagem, deverá ser do tipo png</label>
                                    <input type="file" id="formFile" name="image" class="form-controll-file"/>
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
                                    <button type="submit" class="btn btn-primary" >mudar imagem</button>
                    </form>
                    <form method="POST" action="{{ route('admin.navbar')}}">
                        {{ csrf_field() }}
                        <label for="favcolor">Selecione a cor:</label>
                        <input type="color" id="favcolor" name="cor" value="#ff0000"><br><br>
                        <button type="submit" class="btn btn-primary"  >Mudar cor da NavBar</button>
                    </form>
                    <form method="POST" action="{{ route('admin.avisos')}}">
                        {{ csrf_field() }}
                        <label for="favcolor">Selecione a cor:</label>
                        <input type="color" id="favcolor" name="cor" value="#ff0000"><br><br>
                        <button type="submit" class="btn btn-primary"  >Mudar cor dos avisos</button>
                    </form>
                    <form method="POST" action="{{ route('admin.botoes')}}">
                        {{ csrf_field() }}
                        <label for="favcolor">Selecione a cor:</label>
                        <input type="color" id="favcolor" name="cor" value="#ff0000"><br><br>
                        <button type="submit" class="btn btn-primary"   >Mudar cor dos botoes</button>
                    </form>
                </div>

            </div>
           
        </div>
    </div>
</div>
@endsection

@section('css')
    <style>
    
    </style>
@endsection


@section('js')
<script>
	document.getElementById('nav-configuracoes').classList.add('active');
</script>
@endsection
