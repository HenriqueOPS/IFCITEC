@extends('layouts.app')

@section('css')
<link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endsection

@section('content')
<br><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <center><h2>Cadastro de Voluntário</h2></center>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info text-center">
                            <div class="container-fluid">
                                <div class="alert-icon">
                                    <i class="material-icons">info_outline</i>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                </button>
                                <b>ATENÇÃO: </b>Para ser voluntário, o usuário não pode ter um projeto inscrito na IFCITEC.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="optionsCheckboxes" checked>
                                Estou ciente que caso possua um projeto inscrito na IFCITEC, o mesmo poderá ser desclassificado.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <center> <button class="btn btn-primary">
                            <i class="material-icons">directions_run</i> Quero Ser Voluntário
                        </button></center>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection