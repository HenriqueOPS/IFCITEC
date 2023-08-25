@extends('layouts.app')

@section('content')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteIcons = document.querySelectorAll('.delete-course');
        deleteIcons.forEach(function(icon) {
            icon.addEventListener('click', function() {
                var courseId = icon.getAttribute('data-id');
                if (confirm('Tem certeza de que deseja excluir este curso?')) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '{{ route('admin.cursos.delete') }}', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                    
                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            location.reload();
                        } else {
                            alert('Erro ao excluir o curso.');
                        }
                    };
                    
                    xhr.onerror = function() {
                        alert('Erro na solicitação. Verifique sua conexão.');
                    };
                    
                    xhr.send('id=' + courseId);
                }
            });
        });
    });
</script>

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
                    <thead id="4">
                        <div id="4">
                            <div class="col-md-3">
                                <a data-toggle="modal" data-target="#ModalCurso" class="btn btn-primary btn-round">
                                    <i class="material-icons">add</i> Adicionar Curso
                                </a>
                            </div>
                            </div>
                            <div id="4">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Curso</th>
                                <th>Nível</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </div>
                    </thead>
                    <tbody>
                        @foreach($cursos as $id => $curso)
                        <tr>
                            <td class="text-center">{{$id+1}}</td>
                            <td>{{$curso->nome}}</td>
                            <td>
                                @php
                                $_nivel = \App\Nivel::find($curso->nivel_id);
                                if ($_nivel) {
                                    echo($_nivel->nivel);
                                }
                                @endphp
                            </td>
                            <td class="text-right">
                                <i class="material-icons blue-icon delete-course" data-id="{{$curso->id}}">delete</i>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('partials')
@include('partials.modalCurso', ['nivel' => $nivel])
@endsection

