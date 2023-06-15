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
                            <a href="{{ route('cadastroempresa') }}" class="btn btn-primary btn-round">
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
   
    </script>
@endsection
