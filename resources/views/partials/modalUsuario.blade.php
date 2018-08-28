<!-- Modal Delete Usuário -->
<div id="ModalDeleteUsuário" class="modal fade bd-example-modal-lg" role="dialog4" aria-labelledby="ModalDeleteUsuário">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Deletar Usuário</h5>
			</div>

			<div class="modal-body">
				<span>Para deletar o usuário, confirme sua senha.</span>
				<div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
					<input type="password" placeholder="Senha..." class="form-control" id="passwordDeleteUsuário" name="password" required>
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
	$('.exclusaoUsuario').click(function(){
		var idUsuario= $(this).attr('id-usuario');

		$("#ModalDeleteUsuário").modal();

		$('.excluir').click(function(){
			var urlConsulta = '.././usuario/exclui-usuario/'+idUsuario+'/'+$('#passwordDeleteUsuário').val();
			
			$.get(urlConsulta, function (res){
				if(res == 'true'){
					bootbox.alert("Usuário excluído com sucesso");
					window.location.reload();
				}else{
					bootbox.alert("Senha incorreta");
					window.location.reload();
				}
			});
	
		});

	});
</script>