<html lang="pt-br">
<head>
	<meta charset="utf-8">
	
<style>

@import "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700";

@page{
	size: A4 portrait;
	width: 21cm;
	height: 29.7cm;
	margin: 0;
}

@media all {

	*{
		margin:0;
		padding: 0;
		border: 0;
		-webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
		color-adjust: exact !important;                 /*Firefox*/
	}

	body{font-family: "Roboto", "Helvetica", "Arial", sans-serif;
		margin-left: 4.7mm;
		margin-right: 4.7mm;
		margin-top:9mm;
 
	}
    
	.cracha{
		width: 99mm;
		height: 52.8mm;
		display: inline-block;
		padding:0;
		margin: 0;
		overflow: hidden;
		
	}

	.cracha:nth-child(9n){
		margin-bottom:9mm;
		}

	.cracha .content{
		width: 100%;
		margin: 0mm;
		
	}

	.cracha .dados{
		width: 100%;
		text-align: center;
	}

	.cracha .dados h2,
	.cracha.dados h3{
		width: 100%;
		height: 5mm;
		font-size: 5mm;
		overflow: hidden;
		margin: 0;
		color: #fff;
	}
	
	.cracha .dados h2{
		width: calc(100% - 12mm);
		height: 8mm;
		font-size: 23px;
		line-height: 8mm;
		overflow: hidden;
		padding: 2mm;
		background: rgb(0, 0, 0);
		margin-left: 5mm;
		margin-top: 0mm;
		text-transform: uppercase;
	}
	.cracha .dados h3{
		margin-top: 2mm;
		font-size: 20px;
		width: calc(100% - 12mm);
		margin-left: 5mm;
		text-align: center;
		color: #424a4e;
	}

	.cracha .qrcode{
		width: 25mm;
		margin-top: 1mm;
		margin-left: 37mm;
		margin-right: 37mm ;
	}

}
</style>
</head>
<body>

@foreach($pessoas as $index => $pessoa)
	<div class="cracha">
		<div class="content">
			<div class="dados">
				<h2>{{$funcao}}</h2>
				<h3>{{$pessoa->nome}}</h3>
			</div>
			<img src="{{route('qrcode',$pessoa->id)}}" class="qrcode">
		</div>
	</div>
	@if(($index + 1) % 2 === 0)
		<br> <!-- Adicionar uma quebra de linha a cada dois elementos -->
	@endif
@endforeach


</body>
</html>
