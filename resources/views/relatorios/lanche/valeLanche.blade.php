<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<style>
	@import "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700";
	@page{
		size: A4 portrait;
		width: 21cm;
		height: 29.7cm;
		margin: 0.5cm;
	}
	@media all {
		*{
			margin:0;
			padding: 0;
			border: 0;

		}
		body{font-family: "Roboto", "Helvetica", "Arial", sans-serif;}
		.imagem{
			width: 350px;
			border: 1pt solid #000;
			display: inline-flex;
			padding: 1mm;
			margin: 1mm;
			overflow: hidden;
		}
	}
	</style>
</head>
<body>
@for ($i = 1; $i <= $cont; $i++)
	<img src="{{ asset('img/lanche.png') }}" class="imagem">
@endfor
</body>
</html>
