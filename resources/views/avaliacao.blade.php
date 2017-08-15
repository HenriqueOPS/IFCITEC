@extends('layouts.app')


@section('css')
<link href="{{ asset('css/organization.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-offset-4">
            <ul class="nav nav-pills nav-pills-primary" role="tablist">
                <li>
                    <a href="dashboard" role="tab" data-toggle="tab">
                        <i class="material-icons red-icon">error</i>
                        Reprovados
                    </a>
                </li>
                <li class="active">
                    <a href="#schedule" role="tab" data-toggle="tab">
                        <i class="material-icons gold-icon">warning</i>
                        Homologado com Revisão
                    </a>
                </li>
                <li>
                    <a href="#tasks" role="tab" data-toggle="tab">
                        <i class="material-icons green-icon">done</i>
                        Homologados
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-11 main main-raised"> 
            <div class="list-projects">
                <table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Nomes</th>
            <th>Título</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td>Rafaella Bueno</td>
            <td>IFCITEC</td>
            <td class="td-actions text-right">
                <button type="button" rel="tooltip" title="View Project" class="btn btn-info btn-simple btn-xs">
                    <i class="material-icons blue-icon">description</i>
                </button>
            </td>
        </tr>
 </tbody>
</table>

            </div>
        </div>
    </div>
</div>
@endsection

