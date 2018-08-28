<!-- Modal Tarefa -->
<div id="ModalTarefa" class="modal fade bd-example-modal-lg" role="dialog8" aria-labelledby="ModalTarefa">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tarefaModal"></h5>
			</div>
			<div class="modal-body">

				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">exposure_zero</i>
                </span>
					<div class="form-group label-floating">
						<span id="vagasModal"></span>
					</div>
				</div>

				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">description</i>
                </span>
					<div class="form-group label-floating">
						<span id="descricaoTModal"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
<!-- Fim Modal Tarefa -->


<script type="application/javascript">
$('.modalTarefa').click(function(){

	//recupera o id da tarefa
	var idTarefa = $(this).attr('id-tarefa');

	//monta a url de consulta
	var urlConsulta = '.././tarefa/dados-tarefa/'+idTarefa;
	//faz a consulta via Ajax
	$.get(urlConsulta, function (res){

		console.log(res);

		//altera o DOM
		$("#vagasModal").html(res.dados.vagas);
		$("#tarefaModal").html(res.dados.tarefa);
		$("#descricaoTModal").html(res.dados.descricao);

		//abre a modal
		$("#ModalTarefa").modal();

	});

})
</script>

<!-- Modal Delete Tarefa -->
<div id="ModalDeleteTarefa" class="modal fade bd-example-modal-lg" role="dialog8" aria-labelledby="ModalDeleteTarefa">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Deletar Tarefa</h5>
			</div>

			<div class="modal-body">
				<span>Para deletar a tarefa, confirme sua senha.</span>
				<div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
					<input type="password" placeholder="Senha..." class="form-control" id="passwordDeleteTarefa" name="password" required>
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
	$('.exclusaoTarefa').click(function(){
		var idTarefa= $(this).attr('id-tarefa');

		$("#ModalDeleteTarefa").modal();

		$('.excluir').click(function(){
			var urlConsulta = '.././tarefa/exclui-tarefa/'+idTarefa+'/'+$('#passwordDeleteTarefa').val();
			$.get(urlConsulta, function (res){
				if(res == 'true'){
					bootbox.alert("Tarefa excluída com sucesso");
					window.location.reload();
				}else{
					bootbox.alert("Senha incorreta");
				}

			});
		});

	});
</script>