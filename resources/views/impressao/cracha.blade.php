<html lang="pt-br">
<head>
	<meta charset="utf-8">
	
<style>

	@import "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700";
	@media all {
	@page{
		margin: 2mm;
		padding-top: 10mm;
	}
	*{
		margin:0;
		padding: 0;
		border: 0;
		-webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
		color-adjust: exact !important;                 /*Firefox*/
	}
	body{font-family: "Roboto", "Helvetica", "Arial", sans-serif;}
	ul{
		list-style-type: none;
		width: 240mm;
		display: flex;
		justify-content: flex-start;
		flex-wrap: wrap;
		align-items: center;
		align-content: center;
	}
	ul li{
		width: 110mm;
		height: 167mm;
		padding: 1mm;
		border: 1pt solid #000;
		background: url("{{ asset('img/bg-cracha.png') }}");
		background-size: 100% auto;
	}

	ul li .content{
		width: 100%;
		margin-top: 0mm;
	}
	ul li h2.edicao{
		font-size: 6mm;
		color: #d53835;
	}

	ul li .dados{
		width: 70mm;
		margin-top: 42mm;
		text-align: center;
	}

	ul li .dados h2,
	ul li .dados h3{
		width: 100%;
		height: 5mm;
		font-size: 5mm;
		overflow: hidden;
		margin: 0;
		color: #fff;
	}
	ul li .dados h2{
		width: 66mm;
		height: 8mm;
		line-height: 8mm;
		overflow: hidden;
		padding: 1mm;
		background: #3fa041;
		margin-left: 15mm;
	}
	ul li .dados h3{
		margin-top: 2mm;
		margin-left: 40mm;
		color: #424a4e;
		text-transform: uppercase;
	}

	ul li .qrcode{
		width: 10mm;
		margin-top: 30mm;
		margin-left: 42mm;
	}

	}
</style>
</head>
<body>

<ul>
@foreach($pessoas as $pessoa)

	<li>
		<div class="content">

			<h2 class="edicao">{{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} IFCITEC</h2>

			<div class="dados">
				<h2>{{$pessoa->nome}}</h2>
				<h3>Autor</h3>
			</div>

			<img src="{{route('qrcode',$pessoa->id)}}" class="qrcode">

		</div>
	</li>

	@if($loop->iteration % 4 == 0)
		<li class="line-wrap"></li>
	@endif

@endforeach
</ul>

</body>
</html>
