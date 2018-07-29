<html lang="pt-br">
<head>
	<meta charset="utf-8">
   
<style>
	@media all {

	*{
		margin:0;
		padding: 0;
		border: 0;
		-webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
		color-adjust: exact !important;                 /*Firefox*/
	}
	body{font-family: "Roboto", "Helvetica", "Arial", sans-serif;}
	hr {
      border: 1px solid #000;
      color: #000;
      background-color: #000;
      height: 1px;
    }
    .footer {
		margin: auto;
		width: 100%;
		bottom: 20px;
		position: fixed;
	}
	}
</style>
</head>
<body>
<div class="container">
    <div class="row">
        <img src="{{ asset('img/logo.png') }}" title="IFCITEC" style="width:100; float:left; margin-top: 20px; margin-left: 50px;"/>
        <img src="{{ asset('img/ifrs.png') }}" title="IFCITEC" style="width:150; float:right; margin-top: 20px; margin-right: 50px;"/>
       	<hr style="margin-top: 90px; margin-left: 15px; margin-right: 15px;">
        <div id="gtm" class="container"></div>

        @yield('content')
	</div>
		<div class="footer">	
			<hr style="margin-left: 15px; margin-right: 15px;">
		</div>
</div>

</body>
</html>