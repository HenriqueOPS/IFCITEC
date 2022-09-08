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
							<br>
							<p>Seu trabalho intitulado "{{$titulo}}" foi homologado. Verifique as observações dos homologadores e em caso de alguma solicitação de mudança a mesma deverá ser realizada para a apresentação na feira. Esperamos sua participação presencial na Feira de Ciências e Inovação Tecnológica do IFRS - Campus Canoas.</p>
							<br>
							<p><span style="font-weight: bold;">ATENÇÃO! É necessária a confirmação de presença do projeto na feira, clique no botão abaixo e faça seu login no site.</span></p>
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
													<a href="{{ route('confirmaPresenca', $idProj) }}" target="_blank">Clique aqui para confirmar sua presença na IFCITEC</a>
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
							<p>Fique atento para as datas importantes disponíveis no site do evento.</p>
						</td>
					</tr>

					<tr>
						<td>
							<p>Em caso de qualquer dúvida, faça contato conosco pelo e-mail <a href="mailto:ifcitec@canoas.ifrs.edu.br">ifcitec@canoas.ifrs.edu.br</a> ou pelo nosso Instagram <a href="https://www.instagram.com/ifcitec">@ifcitec</a>.</p>
						</td>
					</tr>

					<tr>
						<td>
							<br>
							<p>Um abraço,</p>
							<p>Comissão Organizadora - IFCITEC</p>
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
