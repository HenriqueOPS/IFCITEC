@extends('layouts.mail')

@section('content')

	<span class="preheader">Prezado(a) {{$nome}},</span>

	<table class="main">
		<tr>
			<td class="wrapper">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center">
							<img src="http://inscricao-ifcitec.canoas.ifrs.edu.br/img/logonormal.png" title="IFCITEC" height="110">
							<br />
							<br />
						</td>
					</tr>
					<tr>
						<td>
							<p>Prezado(a) {{$nome}},</p>
							<br />
							<p>Infelizmente seu trabalho intitulado "{{$titulo}}" não foi homologado. Ainda sim esperamos sua visita virtual na Feira de Ciências e Inovação Tecnológica do IFRS - Campus Canoas e convidamos você a nos seguir no Instagram <a href="https://www.instagram.com/ifcitec">@ifcitec</a>.</p>
						</td>
					</tr>
					<tr>
						<td>
							<br />
							<p>Um abraço,</p>
							<p>Comissão Origanizadora - IFCITEC</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<div class="footer">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td class="content-block">
					<span class="apple-link">IFICTEC - IFRS Câmpus Canoas</span>
				</td>
			</tr>
		</table>
	</div>

@endsection
