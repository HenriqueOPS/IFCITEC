@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<h2>Painel administrativo</h2>
		</div>

		@include('partials.admin.navbar')
	</div>
    <div class="container">
    <div class="row">
        <div class="col-md-12 main main-raised">
            <div class="list-projects">
                <table class="table">
            <thead id="1">
                    <div id="1">
                        <div class="col-md-3">
                            <a href="{{ route('admin.empresas.nova') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Empresa
                            </a>
                        </div>
                    </div>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Empresa</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="1">
                    @foreach($empresas as $i => $empresa)
                    <tr>
                        <td class="text-center">{{ $i+1 }}</td>
                        <td>{{ $empresa['nome_fantasia'] }}</td>
                        <td>{{ $empresa['email'] }}</td>
                        <td>{{ $empresa['telefone'] }}</td>

                        <td class="td-actions text-right">
                      

                    </tr>
                @endforeach

                   
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <style>
        
    </style>
@endsection



@section('js')
<script>
	document.getElementById('nav-empresas').classList.add('active');
</script>
@endsection
