@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 main main-raised" >
                <form method="POST" action="{{ route('admin.background') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <label for="image">Selecione a Imagem</label>
                                    <input type="file" id="File" name="image" class="form-controll-file"/>
                                    <input type="radio" value="background" id="background-radio" name="imagem"/>
                                    <label for="background-radio">background</label>
                                    <input type="radio" value="teladelogin" id="teladelogin-radio" name="imagem"/>
                                    <label for="teladelogin-radio">teladelogin</label>
                                    <input type="radio" value="ifcitecheader" id="ifcitecheader-radio" name="imagem"/>
                                    <label for="ifcitecheader-radio">ifcitecheader</label>
                                    <input type="radio" value="logo" id="logo-radio" name="imagem"/>
                                    <label for="logo-radio">logo navbar</label><br>
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
