@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 main main-raised" >
                <form method="POST" action="{{ route('admin.background') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <label for="image">Selecione a Imagem</label>
                                    <input type="file" id="File" name="image" class="form-controll-file"/>
                                    <button type="submit" class="btn btn-primary" >Concordar</button>
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
