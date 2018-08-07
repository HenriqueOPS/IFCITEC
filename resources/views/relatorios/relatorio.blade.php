<html lang="pt-br">
<head>
	<meta charset="utf-8">
   
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
		background-image: url("../../public/img/relatorio.png");
		padding-top: 30mm;
		margin-left: 2mm;
		background-size:100% 100%;
    	background-attachment: fixed;
	}
	
	hr {
      border: 1px solid #000;
      color: #000;
      background-color: #000;
      height: 1px;
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