<html lang="pt-br">
<head>
	<meta charset="utf-8">
<style>
	@media all {
	@page{
		margin: 5mm;
		padding-top: 60mm;
	}
	*{
		margin:0;
		padding: 0;
		border: 0;
		-webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
		color-adjust: exact !important;                 /*Firefox*/
	}
	ul{
		list-style-type: none;
		display: flex;
		justify-content: flex-start;
		flex-wrap: wrap;
		align-items: center;
		align-content: center;
	}
	body{
		font-family: "Arial", sans-serif;
		background-image: url("{{ asset('img/identificacao.png') }}");
		padding-top: 30mm;
		margin-left: 0mm;
		margin-right: 0mm;
		background-size:100% 100%;
    	background-attachment: fixed;
	}
	ul li h2.fonte{
		font-size: 10mm;
		text-align: center;
		margin-top: 5mm;
	}

	ul li div.bloco{
		margin-left: 135mm;
		border: 1px solid #FF0000;
		border-radius:50px;
		width:100px;
		height:100px;
		background-color: #FF0000;
		line-height:50px;    
		box-shadow: 2px 2px 5px #FF0000;
		color: #FFF;
		text-align: center;
	}

	ul li div.dados{
		text-align: center;
	}
    
    ul li.line-wrap{
		width: 100%;
		height: calc(30mm);
		display: block;
		background: none;
		border: 0;
	}
	}
</style>
</head>
@foreach($areas as $area)
@foreach($area->getClassificacaoCertificados($area->id, $edicao) as $projeto)
@if($loop->iteration == 1)
<p style="color: #FFF">{{$colocacao = 'TERCEIRO LUGAR' }}</p>
@endif
@if($loop->iteration == 2)
<p style="color: #FFF">{{$colocacao = 'SEGUNDO LUGAR' }}</p>
@endif
@if($loop->iteration == 3)
<p style="color: #FFF">{{$colocacao = 'PRIMEIRO LUGAR' }}</p>
@endif
@foreach($projeto->pessoas as $pessoa)
<body>
<ul>
    <li>
    	<div class="content">
	        <div class="dados">
	        		<h1 style="margin-top: 10mm; font-size: 10mm;">CERTIFICADO</h1>
					<p style="margin-top: 10mm; font-size: 4mm;">O Instituto Federal de Educação, Ciência e Tecnologia do Rio Grande do Sul, <br> Campus Canoas, certifica que</p>
					<h1 style="margin-top: 20mm; font-size: 6mm;"><i>{{$pessoa->nome}}</i></h1>
					@if($pessoa->temFuncaoProjeto('Autor', $projeto->id, $pessoa->id, $edicao))
					<p style="margin-top: 20mm; font-size: 4mm;">Autor(a) do projeto {{$projeto->titulo}} obteve o {{$colocacao}} do nível {{$area->niveis->nivel}} da área {{$area->area_conhecimento}} na {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC.</p>
					@endif
					@if($pessoa->temFuncaoProjeto('Orientador', $projeto->id, $pessoa->id, $edicao))
					<p style="margin-top: 20mm; font-size: 4mm;">Orientador(a) do projeto {{$projeto->titulo}} obteve o {{$colocacao}} do nível {{$area->niveis->nivel}} da área {{$area->area_conhecimento}} na {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC.</p>
					@endif
					@if($pessoa->temFuncaoProjeto('Coorientador', $projeto->id, $pessoa->id, $edicao))
					<p style="margin-top: 20mm; font-size: 4mm;">Coorientador(a) do projeto {{$projeto->titulo}} obteve o {{$colocacao}} do nível {{$area->niveis->nivel}} da área {{$area->area_conhecimento}} na {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC.</p>
					@endif
					<p style="margin-top: 15mm; font-size: 4mm;">Canoas, {{$data}}</p>
			</div>
        </div>
        <li class="line-wrap" style="page-break-before: always;"></li>
	</li>
</ul>
</body>
@endforeach
@endforeach
@endforeach
</html>