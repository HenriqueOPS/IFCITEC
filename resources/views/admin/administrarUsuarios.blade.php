@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12 text-center">
            <h2>Administrar Usuários</h2>
        </div>
        <div class="col-md-12 main main-raised">
            <div class="list-projects">
                <table class="table">

                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Usuário</th>
                            <th>Função</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>


                    <tbody>

                        <tr>
                            <td class="text-center">1</td>
                            <td>Rafaella Santana Bueno</td>

                            <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="1">
                                    <span style="color: black">Avaliador</span>
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="1">
                                    <span style="color: black">Homologador</span>
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="1">
                                    <span style="color: black">Organizador</span>
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="2">
                                    <span style="color: black">Voluntário</span>
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="2" checked disabled>
                                    <span style="color: black">Autor</span>
                                </label>
                            </div>
                            </td>
                            <td class="td-actions text-right">
                                <a href="#"><i class="material-icons blue-icon">remove_red_eye</i></a>
                            </td>
                        <tr>

                    </tbody>
                </table>
            </div>

            <div class="col-md-12 text-center">
                <a href="" class="btn btn-primary btn-round">
                    <i class="material-icons">check</i> Salvar Alterações
                </a>
            </div>
        </div>


    </div>
</div>
</div>
@endsection

