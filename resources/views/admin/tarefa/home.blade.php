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
        <div class="col-md-12 col-xs-12 main main-raised">
            <div class="list-projects">
                    <table class="table">
                            <thead id="4">
                    <div id="4">
                        <div class="col-md-3">
                            <a href="{{ route('cadastroTarefa') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Tarefa
                            </a>
                        </div>
                    </div>
                    <div id="4">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Tarefa</th>
                            <th>Descrição</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </div>
                    </thead>

                    <tbody id="4">
                        @foreach($tarefas as $id => $tarefa)
                        <tr>
                            <td class="text-center">{{$id+1}}</td>
                            <td>{{$tarefa->tarefa}}</td>
                            <td>{{$tarefa->descricao}}</td>
                            <td class="text-right">
                            <a href="{{ route('tarefaVoluntarios', $tarefa->id) }}" target="_blank"><i class="material-icons">description</i></a>

                            <a href="javascript:void(0);" class="modalTarefa" data-toggle="modal" data-target="#modal7" id-tarefa="{{ $tarefa->id }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                            <a href="{{ route('tarefa', $tarefa->id) }}"><i class="material-icons">edit</i></a>

                            <a href="javascript:void(0);" class="exclusaoTarefa" id-tarefa="{{ $tarefa->id }}"><i class="material-icons blue-icon">delete</i></a>

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

    @include('partials.modalTarefa')

@endsection
