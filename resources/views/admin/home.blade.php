@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Painel administrativo</h2>
            </div>

            @include('partials.admin.navbar')
  
        </div>
    </div>
    <br><br>
    <div class="container">
        <div class="row">

            <div class="col-md-12 col-xs-12 main main-raised">
                <div class="list-projects">
                    <table class="table">
                        <thead id="0">
                            <div id="0">
                                <div class="col-md-12">
                                    <a href="{{ route('cadastroEdicao') }}" class="btn btn-primary btn-round">
                                        <i class="material-icons">add</i> Adicionar Edição
                                    </a>
                                </div>
                            </div>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Ano</th>
                                <th>Período da feira</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>

                        <tbody id="0">

                            @foreach ($edicoes as $id => $edicao)
                                <div class="col-md-12 col-xs-6">
                                    <tr>
                                        <td class="text-center">{{ $id + 1 }}</td>
                                        <td>{{ \App\Edicao::numeroEdicao($edicao['ano']) }}</td>
                                        <td>
					    {{ date('d/m/Y H:i:s', strtotime($edicao['feira_abertura'])) }} -
                                            {{ date('d/m/Y H:i:s', strtotime($edicao['feira_fechamento'])) }}
					</td>
                                        <td class="td-actions text-right">
                                            <a href="javascript:void(0);" class="modalEdicao" id-edicao="{{ $edicao['id'] }}">
						<i class="material-icons blue-icon">remove_red_eye</i>
					    </a>
                                            <a href="{{ route('editarEdicao', $edicao['id']) }}">
						<i class="material-icons">edit</i>
					    </a>
                                            <a href="javascript:void(0);" class="excluirEdicao" id-edicao="{{ $edicao['id'] }}">
						<i class="material-icons blue-icon">delete</i>
					    </a>
                                        </td>
                                    </tr>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('partials')
    @include('partials.modalEdicao')
@endsection


@section('js')
    <script src="{{ asset('js/main.js') }}"></script>
    <script type="application/javascript">
$(document).ready(function () {

    hideBodys();
    hideHeads();
    $('tbody[id=0]').show();
    $('thead[id=0]').show();
    $('div[id=0]').show();
    $('.tab').click(function (e) {
        var target = $(this)[0];
        hideBodys();
        hideHeads();
        $('tbody[id='+target.id+']').show();
        $('thead[id='+target.id+']').show();
        $('div[id='+target.id+']').show();
    });

    //comissao avaliadora
	$('tr.homologador').hide();

	$('.tab-comissao #homologador').click(function (e) {
		$('tr.avaliador').hide();
		$('tr.homologador').show();
	});

	$('.tab-comissao #avaliador').click(function (e) {
		$('tr.avaliador').show();
		$('tr.homologador').hide();
	});


});

function hideBodys(){
    $('tbody[id=0]').hide();
    $('tbody[id=1]').hide();
    $('tbody[id=2]').hide();
    $('tbody[id=3]').hide();
    $('tbody[id=4]').hide();
    $('tbody[id=5]').hide();
    $('tbody[id=6]').hide();
    $('tbody[id=7]').hide();
    $('tbody[id=8]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    $('div[id=4]').hide();
    $('div[id=5]').hide();
    $('div[id=6]').hide();
    $('div[id=7]').hide();
    $('div[id=8]').hide();
}
function hideHeads(){
    $('thead[id=0]').hide();
    $('thead[id=1]').hide();
    $('thead[id=2]').hide();
    $('thead[id=3]').hide();
    $('thead[id=4]').hide();
    $('thead[id=5]').hide();
    $('thead[id=6]').hide();
    $('thead[id=7]').hide();
    $('thead[id=8]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    $('div[id=4]').hide();
    $('div[id=5]').hide();
    $('div[id=6]').hide();
    $('div[id=7]').hide();
    $('div[id=8]').hide();
}

document.getElementById('nav-edicoes').classList.add('active');

</script>
@endsection
