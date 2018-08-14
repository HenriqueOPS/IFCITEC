<!-- Modal -->
<div id="ModalEdicao" class="modal fade bd-example-modal-lg"  role="dialog" aria-labelledby="ModalEdicao">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="anoModal"></h5>
			</div>
			<div class="modal-body">
				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
					<div class="form-group label-floating">
						<span id="pinsModal"></span>
					</div>
				</div>
				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
					<div class="form-group label-floating">
						<span id="phomModal"></span>
					</div>
				</div>
				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
					<div class="form-group label-floating">
						<span id="pcreModal"></span>
					</div>
				</div>
				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
					<div class="form-group label-floating">
						<span id="pavaModal"></span>
					</div>
				</div>
				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
					<div class="form-group label-floating">
						<span id="pvolModal"></span>
					</div>
				</div>
				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
					<div class="form-group label-floating">
						<span id="piahModal"></span>
					</div>
				</div>
				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
					<div class="form-group label-floating">
						<span id="pfeiModal"></span>
					</div>
				</div>
				<div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">school</i>
                </span>
					<div class="form-group label-floating">
						<span id="testeModal"></span>
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
$('.modalEdicao').click(function(){

	var idEdicao = $(this).attr('id-edicao');

	//monta a url de consulta
	var urlConsulta = './edicao/dados-edicao/'+idEdicao;
	//faz a consulta via Ajax
	$.get(urlConsulta, function (res){

		console.log(res);

		var pins = '';
		var phom = '';
		var pava = '';
		var pvol = '';
		var piah = '';
		var pcre = '';
		var pfei = '';
		var teste = '';
		pins += "Período de Inscrição: ";

		horario(res.dados.inscricao_abertura) ? pins += horario(res.dados.inscricao_abertura)+" até " : pins += '';
		horario(res.dados.inscricao_fechamento) ? pins += horario(res.dados.inscricao_fechamento)+" " : pins += '';

		phom += "Período de Homologação: ";
		horario(res.dados.homologacao_abertura) ? phom += horario(res.dados.homologacao_abertura)+" até " : phom += '';
		horario(res.dados.homologacao_fechamento) ? phom += horario(res.dados.homologacao_fechamento)+" " : phom += '';

		pava += "Período de Avaliação: ";
		horario(res.dados.avaliacao_abertura) ? pava += horario(res.dados.avaliacao_abertura)+" até " : pava += '';
		horario(res.dados.avaliacao_fechamento) ? pava += horario(res.dados.avaliacao_fechamento)+" " : pava += '';

		pcre += "Período de Credenciamento: ";
		horario(res.dados.credenciamento_abertura) ? pcre += horario(res.dados.credenciamento_abertura)+" até " : pcre += '';
		horario(res.dados.credenciamento_fechamento) ? pcre += horario(res.dados.credenciamento_fechamento)+" " : pcre += '';

		pvol += "Período de Inscrição para Voluntário: ";
		horario(res.dados.voluntario_abertura) ? pvol += horario(res.dados.voluntario_abertura)+" até " : pvol += '';
		horario(res.dados.voluntario_fechamento) ? pvol += horario(res.dados.voluntario_fechamento)+" " : pvol += '';

		piah += "Período de Inscrição para Avaliador/Homologador: ";
		horario(res.dados.comissao_abertura) ? piah += horario(res.dados.comissao_abertura)+" até " : piah += '';
		horario(res.dados.comissao_fechamento) ? piah += horario(res.dados.comissao_fechamento)+" " : piah += '';

		pfei += "Período da Feira: ";
		horario(res.dados.feira_abertura) ? pfei += horario(res.dados.feira_abertura)+" até " : pfei += '';
		horario(res.dados.feira_fechamento) ? pfei += horario(res.dados.feira_fechamento)+" " : pfei += '';

		for(var i=0; i<res.nivelEdicao.length; i++) {
			teste += "Nível ";
			res.nivel[i].nivel ? teste += res.nivel[i].nivel+":<br>" : teste
			teste += "      Áreas: ";
			for(var a=0; a<res.areaEdicao.length; a++) {
				if(res.nivel[i].id == res.area[a].nivel_id){
					res.area[a].area_conhecimento ? teste += res.area[a].area_conhecimento+"<br>" : teste += '';
				}
			}
		}
		//altera o DOM
		$("#anoModal").html(numeroEdicao(res.dados.ano));
		$("#pinsModal").html(pins);
		$("#phomModal").html(phom);
		$("#pcreModal").html(pcre);
		$("#pavaModal").html(pava);
		$("#pvolModal").html(pvol);
		$("#piahModal").html(piah);
		$("#pfeiModal").html(pfei);
		$("#testeModal").html(teste);

		//abre a modal
		$("#ModalEdicao").modal();

	});

});

//formata a data passada
// TODO: utilizar um timestamp com a função Date()
function horario(string){
	var ano = string.substring(0,4);
	var mes = string.substring(5,7);
	var dia = string.substring(8,10);
	var hora = string.substring(11,13);
	var minuto = string.substring(14,16);
	var segundo = string.substring(17,19);

	return dia+'/'+mes+'/'+ano+' '+hora+':'+minuto+':'+segundo;
}
</script>

<!-- Modal Delete Edição -->
<div id="ModalDeleteEdicao" class="modal fade bd-example-modal-lg" role="dialog4" aria-labelledby="ModalDeleteEdicao">
	<div class="modal-dialog" role="document4">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Deletar Edição</h5>
			</div>

			<div class="modal-body">
				<span>Para deletar a edição, confirme sua senha.</span>
				<div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
					<input type="password" placeholder="Senha..." class="form-control" id="passwordDeleteEdicao" name="password" required>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary excluir" data-dismiss="modal">Excluir</button>
			</div>
		</div>
	</div>
</div>
<!-- Fim Modal -->

<script type="text/javascript">
	$('.excluirEdicao').click(function(){
		var idEdicao = $(this).attr('id-edicao');

		$("#ModalDeleteEdicao").modal();

		$('.excluir').click(function(){
			var urlConsulta = './edicao/exclui-edicao/'+idEdicao+'/'+$('#passwordDeleteEdicao').val();
			$.get(urlConsulta, function (res){
				if(res == 'true'){
					bootbox.alert("Edição excluída com sucesso");
					window.location.reload();
				}else{
					bootbox.alert("Senha incorreta");
				}

			});
		});

	});
</script>

