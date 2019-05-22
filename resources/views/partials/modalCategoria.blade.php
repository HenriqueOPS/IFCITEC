<!-- Modal -->
<div id="modal-categoria" class="modal fade bd-example-modal-lg"  role="dialog" aria-labelledby="modal-categoria">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nomeCatModal"></h5>
            </div>
            <div class="modal-body">
{{--MUDAR ICONE DO PESO--}}
                <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">assignment</i>
                </span>
                    <div class="form-group label-floating">
                       Peso:  <span id="pesoModal"> </span>
                    </div>
                </div>

                <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">assignment</i>
                </span>
                    <div class="form-group label-floating">
                        <span id="nivelModal"></span>
                    </div>
                </div>

                <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">assignment</i>
                </span>
                    <div class="form-group label-floating">
                        <h4>Itens:</h4>
                    </div>
                </div>


                <div class="input-group">
                    <div class="form-group label-floating">
                        <span id="itensModal">

                        </span>

                    </div>
                    <span>
                        <a href="javascript:void(0);" class="exclusao"><i class="material-icons blue-icon">delete</i></a>
                    </span>
                </div>


                {{--<div class="input-group">--}}
                    {{--<div class="form-group label-floating">--}}
                        {{--<span id="tpItemModal"></span>--}}
                    {{--</div>--}}
                {{--</div>--}}

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal -->

<script type="application/javascript">
    $('.modalCategoria').click(function(){
        //recupera o id da categoria
        var idCategoria = $(this).attr('id-categoria');

        //monta a url de consulta
        var urlConsulta = './dados-categoria/'+idCategoria;

        //faz a consulta via Ajax
        $.get(urlConsulta, function (res){

            console.log(res);

            if(res.categoria) {
                $("#nomeCatModal").html(res.categoria.categoria_avaliacao);
                $("#pesoModal").html(res.categoria.peso);
                $("#nivelModal").html(res.categoria.nivel);
            }

            if(res.campos){
                var html = "<ul style=\"list-style-type: none;\">"

                for(var i in res.campos){
                    html += " <li><h5><input type='checkbox' >"+res.campos[i].campo+ "</h5></li>"
                }
                $("#itensModal").html(html);

            }

            //abre a modal
            $("#modalCategoria").modal();

        });

    })
</script>

<!-- Modal Delete Categoria -->
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

