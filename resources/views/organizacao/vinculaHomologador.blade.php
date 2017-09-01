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
                        <div class="col-md-3 col-md-offset-1" style="border: 1px solid red;">
                           <!-- CARDS DE HOMOLOGADORES AQUI -->
                            <br>
                            CARDS DE HOMOLOGADORES AQUI
                            <br>
                            <br>
                        </div>
                        <div class="col-md-4" style="border: 1px solid blue">
                            Area do ARRASTA
                            <br>
                            <form method="POST" action="#">
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



