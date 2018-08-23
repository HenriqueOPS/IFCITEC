@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="main main-raised">

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h2 class="text-center">Homologar Projetos</h2>
                        </div>
                    </div>

                    <div class="row">
                        <div id="projeto-show">
                            <div class="col-md-5 col-md-offset-1">

                                <span><b id="unselectedCont">--</b> Projetos</span>

                                <div id="list" class="drop-area" style="max-height: 60vh;overflow: auto;">

                                @foreach($projetos as $projeto)

                                    <div class="card no-select" data-id="{{$projeto->id}}">
                                        <div class="content">

                                            <div class="text-right" style="margin-bottom: 5px">
                                                @if($projeto->getStatus() == "Não Homologado" || $projeto->getStatus() == "Não Avaliado")
                                                    <span class="label label-info">{{$projeto->getStatus()}}</span>
                                                @elseif ($projeto->getStatus() == "Homologado" || $projeto->getStatus() == "Avaliado")
                                                    <span class="label label-success">{{$projeto->getStatus()}}</span>
                                                @elseif ($projeto->getStatus() == "Não Compareceu")
                                                    <span class="label label-danger">{{$projeto->getStatus()}}</span>
                                                @else
                                                    <span class="label label-default">{{$projeto->getStatus()}}</span>
                                                @endif
                                            </div>

                                            <div>
                                                <div>
                                                    <i class="material-icons">turned_in</i>
                                                    <span>{{$projeto->titulo}}</span>
                                                </div>

                                                <div>
                                                    <i class="material-icons">school</i>
                                                    <span>{{$projeto->nivel->nivel}}</span>
                                                </div>

                                                <div>
                                                    <i class="material-icons">public</i>
                                                    <span>{{$projeto->areaConhecimento->area_conhecimento}}</span>
                                                </div>

                                                <div>
                                                    <i class="material-icons">show_chart</i>
                                                    <span><b>{{ $projeto->nota }}</b></span>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                @if($projeto->statusHomologacao())
                                                    <span class="label label-success" style="display: inline-flex; width: 20px; padding: 5px;">&nbsp;</span>
                                                @else
                                                    <span class="label label-danger" style="display: inline-flex; width: 20px; padding: 5px;">&nbsp;</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>

                                @endforeach









                                </div>
                            </div>

                            <div class="col-md-5">

                                <span><b id="selectedCont">--</b> Projetos</span>

                                <div id="selected" class="drop-area" style="max-height: 60vh; overflow: auto; background: #f1f1f1;">

                                    <center><span>Arraste o <b>Projeto</b> para este local</span></center>




                                </div>

                                <form method="POST" class="text-center" action="">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="projetosID" name="projetos_id" value="">
                                    <input type="submit" class="btn btn-success" value="SALVAR">
                                </form>
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

        var projects = {{ count($projetos) }};


        var selectedCount = 0;

        var maxSelectedCards = 110;

        var cardsList = document.querySelector('#list');
        var selectedCardsList = document.querySelector('#selected');

        var formHomologadorID = document.querySelector('#projetosID')

        var drag = dragula([cardsList, selectedCardsList], {
            accepts: function (el, target) {
                if (target.id == 'selected') {
                    return selectedCount < maxSelectedCards;
                }
                return true;
            }
        });


        //inicializa os contadores
        $('b#unselectedCont').html(projects - selectedCount);
        $('b#selectedCont').html(selectedCount);


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

            //manipula os contadores
            $('b#unselectedCont').html(projects - selectedCount);
            $('b#selectedCont').html(' '+selectedCount);

        });

        drag.on('dragend', function(){
            selectedCardsList.style.borderColor = '';
            $('#info').innerHTML = '';
        });
    </script>
@endsection



