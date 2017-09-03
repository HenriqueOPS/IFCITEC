@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        <h2>Vinculação de Homologadores</h2>
                    </div>
                </div>
                <div class="row">
                    <div id="projeto-show">
                        <div class="col-md-3 col-md-offset-1">
                           <div id="list" class="drop-area">

                               <div class="card no-select" data-id="1">
                                    <div class="content">
                                        <h5 class="font-weight-bold">
                                            <b><i class="material-icons">person</i></b>
                                            <b>Filipe Oliveira</b>
                                        </h5>
                                        <div>
                                            <div>
                                                <b><i class="material-icons small">book</i></b>
                                                Professor de Física
                                            </div>
                                            <div>
                                                <b><i class="material-icons small">settings</i></b>
                                                5 Projetos
                                            </div>
                                        </div>
                                    </div>
                               </div>



                                <div class="card no-select" data-id="2">
                                    <div class="content">
                                        <h5 class="font-weight-bold">
                                            <b><i class="material-icons">person</i></b>
                                            <b>Guilherme Prezzi</b>
                                        </h5>
                                        <div>
                                            <div>
                                                <b><i class="material-icons small">book</i></b>
                                                Professor de Química
                                            </div>
                                            <div>
                                                <b><i class="material-icons small">settings</i></b>
                                                4 Projetos
                                            </div>
                                        </div>
                                    </div>
                               </div>

                           </div>
                        </div>
                        <div class="col-md-4">
                            <div id="selected" class="drop-area"></div>
                            <form method="POST" class="text-center" action="#">
                                <input type="hidden" id="homologadorID" name="homologadorID" value="">
                                <input type="hidden" id="projetoID" name="projetoID" value="2">
                                <input type="submit" class="btn btn-success" value="SALVAR">
                            </form>
                        </div>
                        <div class="col-md-3">
                            <br>
                            <b><i class="material-icons">group</i> Integrantes:</b>
                            <br>
                            <b>Autor: </b>Rafaella Santana Bueno(rafaellasbueno@gmail.com)<br>
                            <b>Coorientador: </b>carlos(filipeifrscanoas@bol.net)<br>
                            <b>Autor: </b>Filipe de Oliveira de Freitas(filipeifrscanoas@gmail.com)<br>
                            <hr>
                            <b><i class="material-icons">school</i> Nível:</b><br>
                            Ensino Fundamental
                            <hr>
                            <b><i class="material-icons">school</i> Escola:</b><br>
                            IFRS Canoas
                            <hr>
                            <b><i class="material-icons">public</i> Área do Conhecimento:</b><br>
                            Matemática e suas tecnologias/Ciências da Natureza e suas tecnologias
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js"></script>
    <script type="text/javascript">
        var cardsList = document.querySelector('#list');
        var selectedCardsList = document.querySelector('#selected');

        var formHomologadorID = document.querySelector('#homologadorID');
        formHomologadorID.value = '';

        var drag = dragula([cardsList, selectedCardsList]);

        drag.on('drag', function() {
            cardsList.classList.add('active');
            selectedCardsList.classList.add('active');
        });

        drag.on('dragend', function() {
            cardsList.classList.remove('active');
            selectedCardsList.classList.remove('active');
        });

        drag.on('drop', function(el, target) {
            var id = el.getAttribute('data-id');
            if (target.id === 'selected') {
                var value = formHomologadorID.value;

                if (value.length > 0) value = value.concat(',');
                formHomologadorID.value = value.concat(id);
            } else {
                var values = formHomologadorID.value.split(',');
                values.splice(values.indexOf(id), 1);
                formHomologadorID.value = values.join(',');
            }
        });
    </script>
@endsection



