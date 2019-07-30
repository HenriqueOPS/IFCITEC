@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

            <div class="col-md-12 text-center">
                <h2>Painel do Organizador</h2>
            </div>

            <div id="page" class="col-md-12">
                <ul class="nav nav-pills nav-pills-primary">
                    <li class="active">
                        <a href="{{ route('organizador') }}">
                            <i class="material-icons">account_balance</i>
                            Escolas
                        </a>
                    </li>
                    <li>
                        <a href="{{route('organizacao.projetos')}}">
                            <i class="material-icons">list_alt</i>
                            Listar Projetos
                        </a>
                    </li>
                    <li>
                        <a href="{{route('organizacao.presenca')}}">
                            <i class="material-icons">account_circle</i>
                            Presença
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <br><br>
    <div class="container">
        <div class="row">

            <div class="col-md-12 main main-raised">
                <div class="list-projects">
                    <table class="table">
                        <thead id="0">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Escola</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th class="text-right">Ações</th>
                        </tr>
                        </thead>

                        <tbody id="0">

                        @foreach($escolas as $i => $escola)

                            <tr>
                                <td class="text-center">{{ $i+1 }}</td>
                                <td>{{ $escola->nome_curto }}</td>
                                <td>{{ $escola->email }}</td>
                                <td>{{ $escola->telefone }}</td>



                                <td class="td-actions text-right">
                                    <a href="javascript:void(0);" class="modalEscola"  data-toggle="modal" data-target="#modal0" id-escola="{{ $escola->id }}"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                </td>
                            <tr>

                        @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('partials')

<!-- Modal -->
<div id="modal-escola" class="modal fade bd-example-modal-lg"  role="dialog" aria-labelledby="modal-escola">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="nome-curtoModal"></h5>
			</div>
			<div class="modal-body">

				<div class="input-group">
			<span class="input-group-addon">
				<i class="material-icons">assignment</i>
			</span>
					<div class="form-group label-floating">
						<span id="nome-completoModal"></span>
					</div>
				</div>

				<div class="input-group">
			<span class="input-group-addon">
				<i class="material-icons">mail</i>
			</span>
					<div class="form-group label-floating">
						<span id="emailModal"></span>
					</div>
				</div>

				<div class="input-group">
			<span class="input-group-addon">
				<i class="material-icons">phone</i>
			</span>
					<div class="form-group label-floating">
						<span id="telefoneModal"></span>
					</div>
				</div>

				<div class="input-group">
			<span class="input-group-addon">
				<i class="material-icons">location_on</i>
			</span>
					<div class="form-group label-floating">
						<span id="enderecoModal"></span>
					</div>
				</div>

				<div class="input-group">
			<span class="input-group-addon">
				<i class="material-icons">markunread_mailbox</i>
			</span>
					<div class="form-group label-floating">
						<span id="cepModal"></span>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
<!-- Fim Modal -->

<script type="application/javascript">
	$('.modalEscola').click(function(){
		//recupera o id da categoria
		var idEscola = $(this).attr('id-escola');

		//monta a url de consulta
		var urlConsulta = '.././escola/dados-escola/'+idEscola;
		//faz a consulta via Ajax
		$.get(urlConsulta, function (res){

			console.log(res);
			//monta a string do endereço
			var endereco = '';
			var cep = '';

			if(res.data) {
				res.data.endereco ? endereco += res.data.endereco + ", " : endereco += '';
				res.data.numero ? endereco += res.data.numero + ", " : endereco += '';
				res.data.bairro ? endereco += res.data.bairro + ", " : endereco += '';
				res.data.municipio ? endereco += res.data.municipio + ", " : endereco += '';
				res.data.uf ? endereco += res.data.uf + ", " : endereco += '';

				res.data.cep ? cep = res.data.cep : '';
			}

			//altera o DOM
			$("#nome-curtoModal").html(res.dados.nome_curto);
			$("#nome-completoModal").html(res.dados.nome_completo);
			$("#emailModal").html(res.dados.email);
			$("#telefoneModal").html(res.dados.telefone);
			$("#enderecoModal").html(endereco);
			$("#cepModal").html(cep);

			//abre a modal
			$("#modal-escola").modal();

		});

	})
</script>

@endsection
