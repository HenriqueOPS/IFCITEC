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
<body>
@foreach($projetos as $bloco => $proj)
@foreach($proj as $sala => $p)
@foreach($p as $projeto)
<ul>
    <li>

    	<div class="content">
	    	<div class="bloco"><h2 class="fonte">{{$bloco}}{{$sala}}</h2></div>

	        <div class="dados">
	        		<h1 style="margin-top: 10mm; font-size: 10mm;">{{$cont++}}</h1>
					<h1 style="margin-top: 10mm;">{{$projeto->titulo}}</h1>
					<p style="margin-top: 10mm; font-size: 7mm;">IFRS Canoas</p>
					<p style="margin-top: 7mm; font-size: 5mm;">{{$projeto->area_conhecimento}}</p>
					<p style="margin-top: 5mm; font-size: 5mm;">{{$projeto->nivel}}</p>
			</div>
        </div>
        <li class="line-wrap" style="page-break-before: always;"></li>
	</li>
</ul>
@endforeach
@endforeach
@endforeach
</body>
</html>