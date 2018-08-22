@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 1mm; margin-left: 70mm;">RELATÓRIO DE EDIÇÕES</h2>
        <br>
        <p style="text-align: center;"><b> Autores</b></p>
        <br>
        <table style="margin-right: 3pt; margin-left: 3pt; width:100%; border: 1pt solid black; ">
            <thead>
                <tr>
                    <th>Autor</th> 
                    <th>Projeto</th>
                </tr>
            </thead>
            <tbody>
            @foreach($autores as $autor)
            @foreach($projetos as $projeto)
            @if($projeto->id == $autor->projeto_id)
            <tr>
            <td>
            {{$autor->nome}}
            </td> 

            <td>
            {{$projeto->titulo}}
            </td> 

            
            </tr>
            @endif
            @endforeach
            @endforeach    
            </tbody>    
        </table>   
        <br>
        <br>
        <p style="text-align: center;"><b> Orientadores</b></p>
        <br>
        <table style="margin-right: 3pt; margin-left: 3pt; width:100%; border: 1pt solid black; ">
            <thead>
                <tr>
                    <th>Orientador</th> 
                    <th>Projeto</th>
                </tr>
            </thead>
            <tbody>
            @foreach($orientadores as $orientador)
            @foreach($projetos as $projeto)
            @if($projeto->id == $orientador->projeto_id)
            <tr>
            <td>
            {{$orientador->nome}}
            </td> 

            <td>
            {{$projeto->titulo}}
            </td> 

            
            </tr>
            @endif
            @endforeach
            @endforeach    
            </tbody>    
        </table>   
        <br> 
        <br>
        <p style="text-align: center;"><b> Coorientadores</b></p>
        <br>
        <table style="margin-right: 3pt; margin-left: 3pt; width:100%; border: 1pt solid black; ">
            <thead>
                <tr>
                    <th>Coorientador</th> 
                    <th>Projeto</th>
                </tr>
            </thead>
            <tbody>
            @foreach($coorientadores as $coorientador)
            @foreach($projetos as $projeto)
            @if($projeto->id == $coorientador->projeto_id)
            <tr>
            <td>
            {{$coorientador->nome}}
            </td> 

            <td>
            {{$projeto->titulo}}
            </td> 

            
            </tr>
            @endif
            @endforeach
            @endforeach    
            </tbody>    
        </table>   
        <br>     
	</div>
</div>
@endsection

