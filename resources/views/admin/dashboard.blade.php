@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 main main-raised text-center">
			<h2>Dashboard de Avaliação</h2>

			<div class="row" id="cronometro">
				<div class="col-md-6 text-left">
					<span>Última atualização em: <strong class="ultima-atualizacao"></strong></span>
				</div>

				<div class="col-md-6 text-right">
					<span>Próxima atualização em: <strong class="tempo"></strong></span>
				</div>
			</div>

			<div id="dashboard-content"></div>

		</div>
	</div>
</div>

<div id="template-dashboard" style="display: none">

	<div class="row" style="background: #f3f3f3;">

		<h5>Projetos</h5>

		<div class="col-md-6 ">

			<div class="row">
				<div class="col-md-12">
					<h3>{numProjetos}</h3>
					<h4>Projetos</h4>
				</div>
			</div>

			<div class="row">

				<div class="col-md-4">
					<h3>{avaliados}</h3>
					<h4>Já Avaliados</h4>
				</div>

				<div class="col-md-4">
					<h3>{naoAvaliados}</h3>
					<h4>Falta Avaliar</h4>
				</div>

				<div class="col-md-4">
					<h3>{umaAvalicao}</h3>
					<h4>Projetos com 1 avaliação</h4>
				</div>

			</div>

		</div>

		<div class="col-md-6">

			<ul class="grafico">

				<li>
					<span>Já Avaliados</span>

					<div class="barra">
						<div class="preenchido verde percenProjetosJaAvaliados"></div>
					</div>
				</li>

				<li>
					<span>Projetos com 1 avaliação</span>

					<div class="barra">
						<div class="preenchido percenProjetosUmaAvaliacao"></div>
					</div>
				</li>

				<li>
					<span>Falta Avaliar</span>

					<div class="barra">
						<div class="preenchido vermelho percenProjetosFaltaAvaliar"></div>
					</div>
				</li>

			</ul>

		</div>

	</div>

	<div class="row">

		<h5>Avaliadores</h5>

		<div class="col-md-6">

			<ul class="grafico">

				<li>
					<span>Presentes</span>

					<div class="barra">
						<div class="preenchido verde percenAvaliadoresPresentes"></div>
					</div>
				</li>

				<li>
					<span>Não Presentes</span>

					<div class="barra">
						<div class="preenchido vermelho percenAvaliadoresNaoPresentes"></div>
					</div>
				</li>

			</ul>
		</div>

		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<h3>{numAvaliadores}</h3>
					<h4>Avaliadores</h4>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<h3>{presentes}</h3>
					<h4>Presentes</h4>
				</div>

				<div class="col-md-6">
					<h3>{naoPresentes}</h3>
					<h4>Não Presentes</h4>
				</div>
			</div>
		</div>

	</div>

</div>
@endsection

@section('css')
<style>
.grafico {
	width: 100%;
	background: #ffffff;
	list-style-type: none;
	box-sizing: border-box;
	padding: 10px;
	margin: 10px auto;
}

.grafico li {
	width: 100%;
	margin-bottom: 10px;
}

.grafico li span {
	display: block;
	width: 100%;
}

.grafico li .barra {
	width: 100%;
	height: 20px;
	display: block;
	background: #dddddd;
	overflow: hidden;
	border-radius: 3px;
}

.grafico li .barra .preenchido {
	width: 0;
	height: 20px;
	display: block;
	background: #ffab00;
	border-radius: 3px;
	-webkit-transition: width 1.5s; /* For Safari 3.1 to 6.0 */
	transition: width 1.5s;
}

.grafico li .barra .preenchido.vermelho {background: #f04732;}
.grafico li .barra .preenchido.verde {background: #458e33;}

</style>
@endsection

@section('js')
<script>
var tempo;
var intervalo = 180; // em segundos

atualizaDados();
$('#cronometro .ultima-atualizacao').html(currentTime());

setInterval(function () {
    if (tempo <= 0) {
        $('#cronometro .tempo').html('atualizando...');

        atualizaDados();
        return;
	}

	var minutos = Math.floor(tempo / 60);
    var segundos = tempo - (minutos * 60);

	$('#cronometro .tempo').html(beginZero(minutos) + ':' + beginZero(segundos));

    return tempo--;
}, 1000);

function atualizaDados() {
    $.get("/dashboard/data", function (data) {
        $('#cronometro .ultima-atualizacao').html(currentTime());

        var projetos = data.projetos;
        var avaliadores = data.avaliadores;

        var templateDashboard = $('#template-dashboard').html();

        templateDashboard = templateDashboard.replace(/{numProjetos}/g, projetos.numProjetos);
        templateDashboard = templateDashboard.replace(/{avaliados}/g, projetos.avaliados);
        templateDashboard = templateDashboard.replace(/{naoAvaliados}/g, projetos.naoAvaliados);
        templateDashboard = templateDashboard.replace(/{umaAvalicao}/g, projetos.umaAvalicao);

        templateDashboard = templateDashboard.replace(/{presentes}/g, avaliadores.presentes);
        templateDashboard = templateDashboard.replace(/{naoPresentes}/g, avaliadores.naoPresentes);
        templateDashboard = templateDashboard.replace(/{numAvaliadores}/g, avaliadores.numAvaliadores);

        $('#dashboard-content').html(templateDashboard);

        setTimeout(function () {

            // gráfico Projetos
            $('.preenchido.percenProjetosJaAvaliados').css('width', ((projetos.avaliados/projetos.numProjetos) * 100) + '%');
            $('.preenchido.percenProjetosUmaAvaliacao').css('width', ((projetos.umaAvalicao/projetos.numProjetos) * 100) + '%');
            $('.preenchido.percenProjetosFaltaAvaliar').css('width', ((projetos.naoAvaliados/projetos.numProjetos) * 100) + '%');

            // gráfico Avaliadores
            $('.preenchido.percenAvaliadoresPresentes').css('width', ((avaliadores.presentes/avaliadores.numAvaliadores) * 100) + '%');
            $('.preenchido.percenAvaliadoresNaoPresentes').css('width', ((avaliadores.naoPresentes/avaliadores.numAvaliadores) * 100) + '%');

        }, 200);

        console.log(data);

        tempo = intervalo;
    });
}

function beginZero(value) {
    if (value < 10)
        return '0' + value.toString();

    return value;
}

function currentTime() {
    var data = new Date();

    return beginZero(data.getDate()) + '/' +
        beginZero(data.getMonth() + 1) + '/' +
		data.getFullYear() + ' às ' +
        beginZero(data.getHours()) + ':' +
        beginZero(data.getMinutes()) + ':' +
        beginZero(data.getSeconds());
}
</script>
@endsection
