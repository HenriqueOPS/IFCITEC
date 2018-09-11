<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
<style>
	@media all {
	@page{
		margin: 20mm;
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
		margin-left: 3mm;
		margin-right: 2mm;
		background-size:100% 100%;
    	background-attachment: fixed;
	}

	ul li h2.bloco{
		margin-left: 134mm;
		font-size: 6mm;
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
    
	}
</style>
</head>
<body>
<ul>
    <li>
    	<div class="content">
	    	<h2 class="bloco">B12</h2>

	        <div class="dados">
	        		<h1 style="margin-top: 10mm;">1</h1>
					<h1 style="margin-top: 10mm;">Titulo</h1>
					<p style="margin-top: 10mm;">Escola</p>
					<p style="margin-top: 5mm;">area</p>
					<p style="margin-top: 5mm;">nivel</p>
			</div>
        </div>
    
	</li>
</ul>
</body>
</html>