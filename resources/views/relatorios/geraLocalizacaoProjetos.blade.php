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
	body{
		font-family: "Roboto", "Helvetica", "Arial", sans-serif;
		background-image: url("{{ asset('img/identificacao.png') }}");
		padding-top: 30mm;
		margin-left: 0mm;
		margin-right: 0mm;
		background-size:100% 100%;
    	background-attachment: fixed;
	}
    
	}
</style>
</head>
<body>
@foreach($projetos as $bloco => $proj)
@foreach($proj as $sala => $p)
@foreach($p as $projeto)
<div class="container">
    <div class="row" style="margin-bottom: 20mm;">
    	<h2 class="bloco">{{$bloco}}{{$sala}}</h2>

        <div class="dados">
        		<h1>{{$cont++}}</h1>
				<h2>{{$projeto->titulo}}</h2>
				<h2>Escola</h2>
				<h3>{{$projeto->area_conhecimento}}</h3>
				<h3>{{$projeto->nivel}}</h3>
		</div>
        
    
	</div>
</div>
@endforeach
@endforeach
@endforeach
</body>
</html>