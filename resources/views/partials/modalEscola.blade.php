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

<!-- Modal Delete Escola -->
<div id="ModalDeleteEscola" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="ModalDeleteEscola">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Deletar Escola</h5>
			</div>

			<div class="modal-body">
				<span>Para deletar a escola, confirme sua senha.</span>
				<div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
					<input type="password" placeholder="Senha..." class="form-control" id="passwordDeleteEscola" name="password" required>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary excluir" data-dismiss="modal">Excluir</button>
			</div>
		</div>
	</div>
</div>
<!-- Fim Modal -->

<script type="application/javascript">
$('.exclusao').click(function(){
	var idEscola = $(this).attr('id-escola');

	$("#ModalDeleteEscola").modal();

	$('.excluir').click(function(){
		var urlConsulta = '.././escola/exclui-escola/'+idEscola+'/'+$('#passwordDeleteEscola').val();
		$.get(urlConsulta, function (res){
			if(res == 'true'){
				bootbox.alert("Escola Excluída");
				window.location.reload();
			}else if(res == 'password-problem'){
				bootbox.alert("Senha incorreta");
			}else{

			}

		});
	});

});
</script>

