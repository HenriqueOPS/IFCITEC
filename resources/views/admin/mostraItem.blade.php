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
                    <li>
                        <a href="{{ route('cadastroCategoria') }}">
                            <i class="material-icons">description</i>
                            Adicionar Categoria
                        </a>
                    </li>

                    <li>
                        <a  href="{{ route('cadastroCampo') }}" >
                            <i class="material-icons">description</i>
                            Adicionar Item
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mostraCat') }}">
                            <i class="material-icons">list_alt</i>
                            Listar Categorias
                        </a>
                    </li>
                    <li class="active">
                        <a  href="{{ route('mostraItem') }}">
                            <i class="material-icons">list_alt</i>
                            Listar Itens
                        </a>
                    </li>
                    <li>
                        <a id="5" class="tab-projetos" role="tab" data-toggle="tab">
                            <i class="material-icons">description</i>
                            Montar Ficha
                        </a>
                    </li>
                </ul>

                <table class="table">



                    <tr>

                        <th class="text-center">#</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="1">
                    @foreach($it as $i => $its)

                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $its['campo'] }}</td>
                            <td>{{ $its['tipo'] }}</td>

                            {{--PRECISA DE OUTRAS AÇÕES?--}}
                            <td class="td-actions text-right">
                                {{--OK.--}}
                                <a href="javascript:void(0);" class="exclusao" id-item="{{ $its['id'] }}"><i class="material-icons blue-icon">delete</i></a>

                            </td>
                        </tr>

                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('partials')
    <!-- Modal Delete Item -->
    <div id="ModalDeleteItem" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="ModalDeleteItem">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deletar Item</h5>
                </div>

                <div class="modal-body">
                    <span>Para deletar o item, confirme sua senha.</span>
                    <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
                        <input type="password" placeholder="Senha..." class="form-control" id="passwordDeleteItem" name="password" required>
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
            var idItem = $(this).attr('id-item');

            $("#ModalDeleteItem").modal();

            $('.excluir').click(function(){
                //AQUI
                var urlConsulta = './exclui-item/'+idItem+'/'+$('#passwordDeleteItem').val();
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
@endsection



