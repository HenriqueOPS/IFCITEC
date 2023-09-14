
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
	margin-top: 0.9cm;
	margin-left: 0.47cm;
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
		margin: 0px; 
		overflow: visible; 
	}
    
	.cracha{
		width: 9.90cm;
		height: 5.6cm;
		display: inline-block;
		padding:0;
		margin: 0;
		
		
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
	
		margin: 0;
		color: #fff;
	}
	
	.cracha .dados h2{
		width: calc(100% - 12mm);
		height: 8mm;
		line-height: 8mm;
	
		padding: 2mm;
		font-size: 23px;
		background: red;
		margin-left: 5mm;
		margin-top: 0mm;
		text-transform: uppercase;
	}
	.cracha .dados h3{
		font-size: 20px;
		margin-top: 2mm;
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

@foreach($pessoas as $pessoa)

	<div class="cracha">
		<div class="content">

			<div class="dados">
				<h2>{{$funcao}}</h2>
				<h3>{{$pessoa->nome}}</h3>
			</div>

			<img src="{{route('qrcode',$pessoa->id)}}" class="qrcode">

		</div>
	</div>

@endforeach


</body>
</html>
