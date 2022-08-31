<html lang="pt-br">
<head>
	<meta charset="utf-8">
   	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
	<style>
		@media all {
			@page{
				margin: 10mm 0mm 0mm 0mm;
				padding-top: 10mm;
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
				/* background-image: url("{{ asset('img/relatorio.png') }}"); */
			}

			hr { border: 1pt solid #000; }

			tr {
				font-size: 10pt !important;
			}
		}
	</style>
</head>
<body>

<div class="container">
    <div class="row" style="margin-bottom: 20mm;">
        <div id="gtm" class="container"></div>

        @yield('content')
	</div>
</div>

</body>
</html>
