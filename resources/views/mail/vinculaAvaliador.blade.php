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
						<p>Obrigado por contribuir com esta edição da IFCITEC no processo de avaliação.</p>
						<br />
						<p>Você é Avaliador(a) do trabalho intitulado "{{$titulo}}" da Feira de Ciências e Inovação Tecnológica do IFRS - Campus Canoas.</p>
						<br />
						<p>Para avaliar o trabalho, siga os seguintes passos:
							<br />
							1) Compareça presencialmente à IFCITEC e dirija-se à Comissão Organizadora.
							<br />
							2) Faça seu login na plataforma da IFCITEC e clique em Comissão Avaliadora. Aqui você verá a lista de trabalhos para avaliar, seus resumos e a ficha de avaliação a ser preenchida presencialmente.
						</p>
						<br />
						<p>A avaliação acontece no dia da feira: 23 de setembro de 2022 das 9h30 às 12h e das 13h às 15h.</p>
						<br />
						<p>Fique atento para as datas importantes disponíveis no site do evento. Em caso de qualquer dúvida, faça contato conosco pelo e-mail ifcitec@canoas.ifrs.edu.br</p>
					</td>
				</tr>
				<tr>
					<td align="center">
						<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
							<tbody>
								<tr>
									<td align="left">
										<table border="0" cellpadding="0" cellspacing="0">
											<tbody>
												<tr>
													<td>
														<a href="http://inscricao-ifcitec.canoas.ifrs.edu.br" target="_blank">Clique aqui para ver seus projetos</a>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
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
