@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<h2>Painel administrativo</h2>
		</div>

		@include('partials.admin.navbar')
	</div>
</div>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-12 main main-raised">
            <div class="list-projects">
                <table class="table">
            <thead id="1">
                    <div id="1">
                        <div class="col-md-3">
                            <a href="{{ route('cadastroEscola') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Escola
                            </a>
                        </div>
                    </div>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Escola</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="1">

                    @foreach($escolas as $i => $escola)

                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $escola['nome_curto'] }}</td>
                            <td>{{ $escola['email'] }}</td>
                            <td>{{ $escola['telefone'] }}</td>

                            <td class="td-actions text-right">
                                <a href="{{ route('escolaProjetos', $escola['id']) }}" target="_blank"><i class="material-icons">description</i></a>
                                <a href="javascript:void(0);" class="modalEscola"  data-toggle="modal" data-target="#modal0" id-escola="{{ $escola['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('escola', $escola['id']) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusao" id-escola="{{ $escola['id'] }}"><i class="material-icons blue-icon">delete</i></a>
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
    @include('partials.modalEscola')
@endsection

@section('js')
<script>
	document.getElementById('nav-escolas').classList.add('active');
</script>
@endsection
