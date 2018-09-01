@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="main main-raised">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h2>Homologar Trabalhos</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div id="projeto-show">
                            <div class="col-md-3 col-md-offset-1">
                                <div id="list" class="drop-area" style="max-height: 60vh;overflow: auto;">

                                            <div class="card no-select" data-id="3">
                                                <div class="content">
                                           <span class="font-weight-bold">
                                               <b><i class="material-icons">person</i></b>
                                               <b>nome</b>
                                           </span>
                                                    <div>
                                                        <div>
                                                            <b><i class="material-icons small">book</i></b>
                                                            titulação
                                                        </div>
                                                        <div>
                                                            <b><i class="material-icons small">settings</i></b>
                                                            asdf projetos
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <center><span>Arraste o Homologador para este local</span></center>
                                <div id="selected" class="drop-area">

                                            <div class="card no-select" data-id="2">
                                                <div class="content">
                                           <span class="font-weight-bold">
                                               <b><i class="material-icons">person</i></b>
                                               <b>nome</b>
                                           </span>
                                                    <div>
                                                        <div>
                                                            <b><i class="material-icons small">book</i></b>
                                                            ddfasd
                                                        </div>
                                                        <div>
                                                            <b><i class="material-icons small">settings</i></b>
                                                            asdf projetos
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                </div>
                                <form method="POST" class="text-center" action="{{route('vinculaRevisorPost')}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="projetoID" name="projetos_id" value="1">
                                    <input type="submit" class="btn btn-success" value="SALVAR">
                                </form>
                                <div class="text-center">
                                    <a href="{{route('administrador.projetos')}}" class="btn btn-default">Voltar</a>
                                </div>
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
        // Pre initialized by Backend

        var selectedCount = 1;


        var maxSelectedCards = 2;

        var cardsList = document.querySelector('#list');
        var selectedCardsList = document.querySelector('#selected');

        var formHomologadorID = document.querySelector('#revisorID')

        var drag = dragula([cardsList, selectedCardsList], {
            accepts: function (el, target) {
                if (target.id == 'selected') {
                    return selectedCount < maxSelectedCards;
                }
                return true;
            }
        });

        drag.on('drag', function(el, source) {
            cardsList.classList.add('active');
            selectedCardsList.classList.add('active');
            selectedCardsList.style.borderColor = '';

            if (source.id != 'selected' && selectedCount >= maxSelectedCards)
                selectedCardsList.style.borderColor = 'red';
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
                selectedCount++;
            } else {
                var values = formHomologadorID.value.split(',');
                values.splice(values.indexOf(id), 1);
                formHomologadorID.value = values.join(',');
                selectedCount--;
            }
        });

        drag.on('dragend', function(){
            selectedCardsList.style.borderColor = '';
            $('#info').innerHTML = '';
        });
    </script>
@endsection


