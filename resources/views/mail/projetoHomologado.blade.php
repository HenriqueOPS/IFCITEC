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
							<p>Seu trabalho intitulado "{{$titulo}}" foi homologado. Verifique as observações dos homologadores e em caso de alguma solicitação de mudança a mesma deverá ser realizada para no vídeo a ser apresentado na feira. Esperamos sua participação virtual na Feira de Ciências e Inovação Tecnológica do IFRS - Campus Canoas.</p>
							<br>
							<p><span style="font-weight: bold;">ATENÇÃO! É necessária a confirmação de presença do projeto na feira, clique no botão abaixo e faça seu login no site, se o seu projeto enviará os vídeos da próxima etapa o que configura a participação na IFCITEC.</span></p>
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
													<a href="{{ route('confirmaPresenca', $idProj) }}" target="_blank">Clique aqui para confirmar sua presença virtual na IFCITEC</a>
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
							<p>
								<b>Importante:</b>  agora o seu projeto precisa, até o dia 27/10/2021, enviar o vídeo de divulgação de sua pesquisa com até 60 segundos em formato MP4 para o REELS da IFCITEC e o link do vídeo de apresentação de seu projeto postado no YouTube (ver detalhes no regulamento).
								<br /><br />
								O envio do vídeo e do link do YouTube deve ser feito através <a href="https://forms.gle/yL5qPZoxVw3hAJVP8">deste formulário</a>.
							</p>
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
