@extends('layouts.mail')

@section('content')

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
							<p>Você está recebendo esse e-mail pois recebemos um pedido de redefinição de senha da sua conta.</p>
							<br />
							<p>Se você não deseja redefinir sua senha, ignore este e-mail.</p>
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
														<a href="{{ route('password.reset', $token) }}">Clique aqui para redefinir sua senha</a>
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
					<span class="apple-link">IFCITEC - IFRS Câmpus Canoas</span>
				</td>
			</tr>
		</table>
	</div>

@endsection
