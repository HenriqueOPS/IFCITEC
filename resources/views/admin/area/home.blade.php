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
                        <thead id="3">
                            <div id="3">
                                <div class="col-md-3 col-xs-3">
                                    <a href="{{ route('cadastroArea') }}" class="btn btn-primary btn-round">
                                        <i class="material-icons">add</i> Adicionar Área
                                    </a>
                                </div>
                            </div>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Área do Conhecimento</th>
                                <th>Nível</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>

                        <tbody id="3">
                            @foreach ($areas as $id => $area)
                                <tr>
                                    <td class="text-center">{{ $id + 1 }}</td>
                                    <td>{{ $area['area_conhecimento'] }}</td>

                                    <td>{{ $area->niveis()->first()->nivel }}</td>

                                    <td class="td-actions text-right">
                                        <a href="{{ route('areaProjetos', $area['id']) }}" target="_blank"><i
                                                class="material-icons">description</i></a>

                                        <a href="javascript:void(0);" class="modalArea" data-toggle="modal"
                                            data-target="#modal2" id-area="{{ $area['id'] }}"><i
                                                class="material-icons blue-icon">remove_red_eye</i></a>

                                        <a href="{{ route('area', $area['id']) }}"><i class="material-icons">edit</i></a>

                                        <a href="javascript:void(0);" class="exclusaoArea" id-area="{{ $area['id'] }}"><i
                                                class="material-icons blue-icon">delete</i></a>
                                    </td>
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

@section('partials')
    @include('partials.modalArea')
@endsection

@section('js')
<script>
    document.getElementById('nav-areas').classList.add('active');
</script>
@endsection