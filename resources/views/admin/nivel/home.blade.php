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
                        <thead id="2">
                    <div id="2">
                        <div class="col-md-3">
                            <a href="{{ route('cadastroNivel') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Nível
                            </a>
                        </div>
                    </div>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nível</th>
                        <th>Descrição</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="2">

                    @foreach($niveis as $i => $nivel)

                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $nivel['nivel'] }}</td>
                            <td>{{ $nivel['descricao'] }}</td>

                            <td class="td-actions text-right">
                                <a href="{{ route('nivelProjetos', $nivel['id']) }}" target="_blank"><i class="material-icons">description</i></a>

                                <a href="javascript:void(0);" class="modalNivel" data-toggle="modal" data-target="#modal1" id-nivel="{{ $nivel['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('nivel', $nivel['id']) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusaoNivel" id-nivel="{{ $nivel['id'] }}"><i class="material-icons blue-icon">delete</i></a>
                            </td>
                        <tr>

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

    @include('partials.modalNivel')

@endsection

@section('js')
<script>
	document.getElementById('nav-niveis').classList.add('active');
</script>
@endsection
