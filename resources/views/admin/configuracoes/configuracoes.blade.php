@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 main main-raised" >
                <form method="POST" action="{{ route('admin.background') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <label for="image">Selecione a Imagem</label>
                                    <input type="file" id="File" name="image" class="form-controll-file"/>
                                    <button type="submit" class="btn btn-primary" >mudar imagem</button>
                </form>
                <form method="POST" action="{{ route('admin.navbar')}}">
                {{ csrf_field() }}
                <label for="favcolor">Selecione a cor:</label>
                <input type="color" id="favcolor" name="cor" value="#ff0000"><br><br>
                <button type="submit" class="btn btn-primary"  >Mudar cor da NavBar</button>
                </form>
              

            </div>
           
        </div>
    </div>
@endsection

@section('css')
    <style>
        
    </style>
@endsection


@section('js')
  <script>
   
    </script>
@endsection
