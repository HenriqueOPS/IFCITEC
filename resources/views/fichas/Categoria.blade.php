@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">

        <div class="row">

            <div class="col-md-12 main main-raised">

                <div class="col-md-12 text-center">
                    <h2>Painel administrativo</h2>
                    <h3>Fichas</h3>
                </div>

                <ul class="nav nav-pills nav-pills-primary" role="tablist" style="margin-bottom: 30px">
                    <li  class="active">
                        <a href="{{ route('mostraCat') }}">
                            <i class="material-icons">list_alt</i>
                            Categoria
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('listaCat') }}">
                            <i class="material-icons">description</i>
                            Critérios de Avaliação
                        </a>
                    </li>

                    {{--<li>--}}
                        {{--<a  href="{{ route('mostraItem') }}">--}}
                            {{--<i class="material-icons">list_alt</i>--}}
                            {{--Listar Itens--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li>
                        <a href="{{ route('telaEscolheTipo') }}">
                            <i class="material-icons">description</i>
                            Montar Formulário
                        </a>
                    </li>
                </ul>

                <div id="1">
                    <div class="col-md-3">
                        <a href="{{ route('cadastroCategoria') }}" class="btn btn-primary btn-round">
                            <i class="material-icons">add</i> Adicionar Categoria
                        </a>
                    </div>
                </div>
    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-12 main main-raised">--}}
                {{--<div class="list-projects">--}}
                    <table class="table">



                        <tr>

                            <th class="text-center">#</th>
                            <th>Categoria</th>
                            <th>Peso</th>
                            <th class="text-right">Ações</th>
                        </tr>
                        </thead>

                        <tbody id="1">
                        @foreach($cat as $i => $cats)

                            <tr>
                                <td class="text-center">{{ $i+1 }}</td>
                                <td>{{ $cats['descricao'] }}</td>
                                <td>{{ $cats['peso'] }}</td>

                                <td class="td-actions text-right">

                                    {{--OK, precisa excluir itens tbm?--}}
                                    <a href="javascript:void(0);" class="exclusao" id-categoria="{{ $cats['id'] }}"><i class="material-icons blue-icon">delete</i></a>                                    {{--?????--}}
                                    <a href="{{ route('editarCat', $cats['id']) }}"><i class="material-icons">edit</i></a>

                                </td>
                            </tr>

                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    {{--</div>--}}
    {{--</div>--}}
@endsection

@section('partials')
    <script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>
    {{--@include('partials.modalCategoria')--}}

    <div id="ModalDeleteCategoria" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="ModalDeleteCategoria">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deletar Categoria</h5>
                </div>

                <div class="modal-body">
                    <span>Para deletar a categoria, confirme sua senha.</span>
                    <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
                        <input type="password" placeholder="Senha..." class="form-control" id="passwordDeleteCategoria" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary excluir" data-dismiss="modal">Excluir</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Modal -->
    <script type="application/javascript">
        $('.exclusao').click(function(){
            var idCategoria = $(this).attr('id-categoria');

            $("#ModalDeleteCategoria").modal();

            $('.excluir').click(function(){
                //AQUI
                var urlConsulta = './exclui-categoria/'+idCategoria+'/'+$('#passwordDeleteCategoria').val();
                $.get(urlConsulta, function (res){
                    if(res == 'true'){
                        bootbox.alert("Categoria Excluída");
                        window.location.reload();
                    }else if(res == 'password-problem'){
                        bootbox.alert("Senha incorreta");
                    }else{

                    }

                });
            });

        });
    </script>

    {{--<script type="application/javascript">--}}
        {{--$('.exclusao').click(function(){--}}
            {{--var idCategoria = $(this).attr('id-categoria');--}}

            {{--$("#ModalDeleteCategoria").modal();--}}

            {{--$('.excluir').click(function(){--}}
                {{--//AQUI--}}
                {{--var urlConsulta = './exclui-categoria/'+idCategoria+'/'+$('#passwordDeleteCategoria').val();--}}
                {{--$.get(urlConsulta, function (res){--}}
                    {{--if(res == 'true'){--}}
                        {{--bootbox.alert("Categoria Excluída");--}}
                        {{--window.location.reload();--}}
                    {{--}else if(res == 'password-problem'){--}}
                        {{--bootbox.alert("Senha incorreta");--}}
                    {{--}else{--}}

                    {{--}--}}

                {{--});--}}
            {{--});--}}

        {{--});--}}
    {{--</script>--}}

@endsection



