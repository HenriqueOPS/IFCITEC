
<!-- Modal Nível -->
<div id="ModalNivel" class="modal fade bd-example-modal-lg" role="dialog2" aria-labelledby="ModalNivel">
	<div class="modal-dialog" role="document2">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="nivelModal"></h5>
			</div>
			<div class="modal-body">

				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">remove_circle</i>
                </span>
					<div class="form-group label-floating">
						<span id="min_chModal"></span>
					</div>
				</div>

				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">add_box</i>
                </span>
					<div class="form-group label-floating">
						<span id="max_chModal"></span>
					</div>
				</div>

				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">exposure_zero</i>
                </span>
					<div class="form-group label-floating">
						<span id="palavrasModal"></span>
					</div>
				</div>

				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">description</i>
                </span>
					<div class="form-group label-floating">
						<span id="desModal"></span>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
<!-- Fim Modal Nível -->

<script type="application/javascript">
$('.modalNivel').click(function(){

	var idNivel = $(this).attr('id-nivel');

	//monta a url de consulta
	var urlConsulta = '.././nivel/dados-nivel/'+idNivel;
	//faz a consulta via Ajax
	$.get(urlConsulta, function (res){

		console.log(res);

		//altera o DOM
		$("#nivelModal").html(res.nivel);
		$("#min_chModal").html(res.min_ch);
		$("#max_chModal").html(res.max_ch);
		$("#desModal").html(res.descricao);
		$("#palavrasModal").html(res.palavras);

		//abre a modal
		$("#ModalNivel").modal();

	});

})
</script>

<!-- Modal Delete Nível -->
<div id="ModalDeleteNivel" class="modal fade bd-example-modal-lg" role="dialog3" aria-labelledby="ModalDeleteNivel">
	<div class="modal-dialog" role="document3">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Deletar Nível</h5>
			</div>

			<div class="modal-body">
				<span>Para deletar o nível, confirme sua senha.</span>
				<div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
					<input type="password" placeholder="Senha..." class="form-control" id="passwordDeleteNivel" name="password" required>
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
$('.exclusaoNivel').click(function(){
	var idNivel= $(this).attr('id-nivel');

	$("#ModalDeleteNivel").modal();

	$('.excluir').click(function(){
		var urlConsulta = '.././nivel/exclui-nivel/'+idNivel+'/'+$('#passwordDeleteNivel').val();
		$.get(urlConsulta, function (res){
			if(res == 'true'){
				bootbox.alert("Nível excluído com sucesso");
				window.location.reload();
			}else{
				bootbox.alert("Senha incorreta");
			}

		});
	});

});
</script>


