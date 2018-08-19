<html lang="pt-br">
<head>
	<meta charset="utf-8">
	
<style>

	@import "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700";
	@media all {

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
		width: 200mm;
		display: flex;
		justify-content: flex-start;
		flex-wrap: wrap;
		align-items: center;
		align-content: center;
	}
	ul li{
		width: 100mm;
		height: 132mm;
		padding: 5mm;
		border: 1pt solid #000;
		background: url("{{ asset('img/bg-cracha.png') }}");
		background-size: 12px;
	}

	ul li.line-wrap{
		width: 100%;
		height: calc(20mm + 1pt);
		display: block;
		background: none;
		border: 0;
	}

	ul li .content{
		width: 100%;
		margin-top: 15mm;
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
		padding: 2mm;
		background: #3fa041;
	}
	ul li .dados h3{
		margin-top: 2mm;
		color: #424a4e;
		text-transform: uppercase;
	}

	ul li .qrcode{
		width: 20mm;
		margin-top: 20mm;
	}

	}
</style>
</head>
<body>

<ul>
@foreach($pessoas as $pessoa)

	<li>
		<div class="content">

			<h2 class="edicao">VI IFCITEC</h2>

			<div class="dados">
				<h2>{{$pessoa->nome}}</h2>
				<h3>Autor</h3>
			</div>

			<img src="/cracha/qr-code/{{$pessoa->id}}" class="qrcode">

		</div>
	</li>

	@if($loop->iteration % 4 == 0)
		<li class="line-wrap"></li>
	@endif

@endforeach
</ul>

</body>
</html>
