<html lang="pt-br">
<head>
	<meta charset="utf-8">
	
<style>

	@import "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700";
	@media all {
	div { float: none !important; position: static !important; display: inline; 
          box-sizing: content-box !important;
    }
	@page{
		margin: 2mm;
		width: 200mm;
		height: 290mm;
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
		width: 112mm;
		height: 155mm;
		padding: 1mm;
		border: 1pt solid #000;
		background: url("{{ asset('img/bg-cracha.png') }}");
		background-size: 100% 100%;
	}
	ul li.line-wrap{
		width: 100%;
		height: calc(1pt);
		display: block;
		background: none;
		border: 0;
	}
	ul li.line-wrap-2{
		width: calc(1pt);
		display: block;
		background: none;
		border: 0;
	}
	ul li.line-wrap-4{
		width: 100%;
		height: calc(40mm + 1pt);
		display: block;
		background: none;
		border: 0;
	}
	ul li .content{
		width: 100%;
	}
	ul li h2.edicao{
		margin-top: 15mm;
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
		margin-left: 22mm;
		margin-top: 60mm;
		text-transform: uppercase;
	}
	ul li .dados h3{
		margin-top: 2mm;
		margin-left: 22mm;
		color: #424a4e;
	}

	ul li .qrcode{
		width: 30mm;
		margin-top: 10mm;
		margin-left: 42mm;
	}
</style>
</head>
<body>
<ul>
@foreach($pessoas as $pessoa)
	@if($loop->iteration % 1 == 0 && $loop->iteration % 2 != 0)
		<li class="line-wrap-2"></li>
		<li class="line-wrap-2"></li>
	@endif
	@if($loop->iteration % 2 == 0)
		<li class="line-wrap-2"></li>
	@endif
	<li>
		<div class="content">

			<h2 class="edicao">{{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} IFCITEC</h2>

			<div class="dados">
				<h2>{{$funcao}}</h2>
				<h3>{{$pessoa->nome}}</h3>
			</div>

			<img src="{{route('qrcode',$pessoa->id)}}" class="qrcode">

		</div>
	</li>
	@if($loop->iteration % 2 == 0 && $loop->iteration % 4 != 0)
		<li class="line-wrap"></li>
	@endif
	@if($loop->iteration % 4 == 0)
		<li class="line-wrap-4" style="page-break-before: always;"></li>
	@endif

@endforeach
</ul>

</body>
</html>
