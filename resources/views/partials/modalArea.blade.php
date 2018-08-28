<!-- Modal Área -->
<div id="ModalArea" class="modal fade bd-example-modal-lg" role="dialog2" aria-labelledby="ModalArea">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="areaModal"></h5>
			</div>
			<div class="modal-body">

				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">school</i>
                </span>
					<div class="form-group label-floating">
						<span id="nivelAreaModal"></span>
					</div>
				</div>

				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">description</i>
                </span>
					<div class="form-group label-floating">
						<span id="descricaoModal"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
<!-- Fim Modal Área -->


<script type="application/javascript">
$('.modalArea').click(function(){

	//recupera o id da escola
	var idArea = $(this).attr('id-area');

	//monta a url de consulta
	var urlConsulta = '.././area/dados-area/'+idArea;
	//faz a consulta via Ajax
	$.get(urlConsulta, function (res){

		console.log(res);

		//altera o DOM
		$("#nivelAreaModal").html(res.data);
		$("#areaModal").html(res.dados.area_conhecimento);
		$("#descricaoModal").html(res.dados.descricao);

		//abre a modal
		$("#ModalArea").modal();

	});

})
</script>

<!-- Modal Delete Área -->
<div id="ModalDeleteArea" class="modal fade bd-example-modal-lg" role="dialog3" aria-labelledby="ModalDeleteArea">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Deletar Área</h5>
			</div>

			<div class="modal-body">
				<span>Para deletar a área, confirme sua senha.</span>
				<div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
					<input type="password" placeholder="Senha..." class="form-control" id="passwordDeleteArea" name="password" required>
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
	$('.exclusaoArea').click(function(){
		var idArea= $(this).attr('id-area');

		$("#ModalDeleteArea").modal();

		$('.excluir').click(function(){
			var urlConsulta = '.././area/exclui-area/'+idArea+'/'+$('#passwordDeleteArea').val();
			$.get(urlConsulta, function (res){
				if(res == 'true'){
					bootbox.alert("Área do conhecimento excluída com sucesso");
					window.location.reload();
				}else{
					bootbox.alert("Senha incorreta");
				}

			});
		});

	});
</script>
