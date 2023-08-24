@extends('layouts.app')

@section('content')
<script>    
function oculto($id,$estado){
        $estado = !$estado
        $.ajax({
            url: '/ocultarusuario-admin/' + $id,
            type: 'POST',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                estado: $estado // Certifique-se de que esta variável esteja definida
            },
            success: function(response) {
                // Faça algo aqui após a ocultação do usuário
                alert(response.message);
            },
            error: function(error) {
                // Trate erros aqui
                alert('Erro ao ocultar usuário: ', error.message);
            }
        });
    }
   </script>
<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<h2>Painel administrativo</h2>
		</div>

		@include('partials.admin.navbar')

	</div>
</div>
<br><br>
<script>
    function filtrarOcultos() {
        const ocultosCheckbox = document.getElementById('ocultosCheckbox');
        const registros = document.querySelectorAll('.oculto');

        registros.forEach(registro => {
            registro.style.display = ocultosCheckbox.checked ? 'none' : 'table-row';
        });
    }
</script>



<div class="container">
    <div class="row">
        <div class="col-md-12 main main-raised">
            <div class="list-projects">
            <div class="form-check">
    <input class="form-check-input" type="checkbox" id="ocultosCheckbox" onClick="filtrarOcultos()">
    <label class="form-check-label" for="ocultosCheckbox">
        Mostrar Ocultos
    </label>
</div>

<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Usuários</th>
            <th>Oculto</th>
            <th>E-mail</th>
            <th class="text-right">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $key => $usuario)
        <tr id="registro{{$usuario->id}}" class="{{$usuario->oculto ? '' : 'oculto'}}">
            <td class="text-center">{{$key + 1}}</td>
            <td>{{$usuario->nome}}</td>
            <td>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch{{$usuario->id}}" onclick="oculto({{$usuario->id}}, {{$usuario->oculto}})" {{$usuario->oculto ? 'checked' : ''}}>
                    <label class="custom-control-label" for="customSwitch{{$usuario->id}}">Oculto</label>
                </div>
            </td>
            <td>{{$usuario->email}}</td>
            <td class="text-right">
                <a href="{{route('editarUsuario',$usuario->id)}}"><i class="material-icons">edit</i></a>
                <a href="{{route('editarFuncaoUsuario',$usuario->id)}}"><i class="material-icons">person_add</i></a>
                <a href="{{route('ocultarUsuario',$usuario->id)}}"><i class="material-icons">block</i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('partials')

    @include('partials.modalUsuario')

@endsection

@section('js')
<script>

	document.getElementById('nav-usuarios').classList.add('active');
</script>
@endsection
