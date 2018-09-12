<html lang="pt-br">
<head>
	<meta charset="utf-8">
	
<style>

	@import "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700";
	@media all {
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
		width: 80mm;
		height: 40mm;
		padding: 1mm;
		border: 1pt solid #000;
		background: url("{{ asset('img/lanche.png') }}");
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
		height: calc(21mm);
		display: block;
		background: none;
		border: 0;
	}
	ul li .content{
		width: 100%;
		margin-top: 0mm;
	}
	}
</style>
</head>
<body>
<ul>
	<li>
		<div class="content">


		</div>
	</li>
</ul>

</body>
</html>