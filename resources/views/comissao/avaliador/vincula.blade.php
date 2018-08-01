@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        <h2>Vinculação de Avaliadores</h2>
                    </div>
                </div>
                <div class="row">
                    <div id="projeto-show">
                        <div class="col-md-3 col-md-offset-1">
                           <div id="list" class="drop-area" style="max-height: 60vh;overflow: auto;">
                               @foreach($avaliadores as $avaliador)
                                   @if(!in_array($avaliador->id, $idAvaliadores))
                                       <div class="card no-select" data-id="{{$avaliador->id}}">
                                           <div class="content">
                                               <span class="font-weight-bold">
                                                   <b><i class="material-icons">person</i></b>
                                                   <b>{{$avaliador->nome}}</b>
                                               </span>
                                               <div>
                                                   <div>
                                                       <b><i class="material-icons small">book</i></b>
                                                       {{$avaliador->titulacao}}
                                                   </div>
                                                   <div>
                                                       <b><i class="material-icons small">settings</i></b>
                                                       {{$avaliador->num_projetos}} projetos
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   @endif
                               @endforeach
                           </div>
                        </div>
                        <div class="col-md-4">
                            <center><span>Arraste os Avaliador (max. 2) para este local</span></center>
                            <div id="selected" class="drop-area">
                                @if($projeto->avaliacoes->isNotEmpty())
                                    @foreach($projeto->avaliacoes as $avaliacao)
                                    <div class="card no-select" data-id="{{$avaliacao->pessoa->id}}">
                                        <div class="content">
                                           <span class="font-weight-bold">
                                               <b><i class="material-icons">person</i></b>
                                               <b>{{$avaliacao->pessoa->nome}}</b>
                                           </span>
                                            <div>
                                                <div>
                                                    <b><i class="material-icons small">book</i></b>
                                                    {{$avaliacao->pessoa->titulacao}}
                                                </div>
                                                <div>
                                                    <b><i class="material-icons small">settings</i></b>
                                                    {{$avaliacao->pessoa->getTotalAvaliacoes()}} projetos
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif

                            </div>
                            <form method="POST" class="text-center" action="{{route('vinculaAvaliadorPost')}}">
                                {{ csrf_field() }}
                                <input type="hidden" id="revisorID" name="avaliadores_id" value="{{$avaliadoresValue}}">
                                <input type="hidden" id="projetoID" name="projeto_id" value="{{$projeto->id}}">
                                <input type="submit" class="btn btn-success" value="SALVAR">
                            </form>
                            <div class="text-center">
                                <a href="{{route('home')}}" class="btn btn-default">Voltar</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <br>
                            <b><i class="material-icons">group</i> Título:</b>
                            <br>
                            {{$projeto->titulo}}
                            <hr>
                            <b><i class="material-icons">school</i> Nível:</b><br>
                            {{$projeto->nivel->nivel}}
                            <hr>
                            <b><i class="material-icons">school</i> Escola:</b><br>
                            {{App\Escola::find($projeto->pessoas[0]->pivot->escola_id)->nome_curto}}
                            <hr>
                            <b><i class="material-icons">public</i> Área do Conhecimento:</b><br>
                            {{$projeto->areaConhecimento->area_conhecimento}}
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
                @if($projeto->revisoes->isNotEmpty())
        var selectedCount = {{$projeto->avaliacoes->count()}};
                @else
        var selectedCount = 0;
                @endif

        var maxSelectedCards = 2;

        var cardsList = document.querySelector('#list');
        var selectedCardsList = document.querySelector('#selected');

        var formHomologadorID = document.querySelector('#revisorID');
        //formHomologadorID.value = '';


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



