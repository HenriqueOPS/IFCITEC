@extends('layouts.app')

@section('css')
    <style>
        .menu-mensagens {
            width: 30%;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            padding: 0%;
        }

        .controles {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-end;
            width: 100%;
            height: 4%;
        }

        .main-box {
            display: flex;
            flex-direction: row;
            background-color: inherit;
            background-color: white;
            margin: 2%;
            margin-bottom: 0pt;
            filter: drop-shadow(10pt 4pt 4pt rgba(0, 0, 0, 0.39));
        }

        #mensagens {
            background-color: whitesmoke;
            width: 95%;
            height: 96%;
        }

        #add-btn {
          transition: 0.1s all;
          background-color: white;
          width: 95%;
          text-align: center;
        }

        #add-btn:hover {
            filter: drop-shadow(1pt 2pt 5pt rgba(0, 0, 0, 0.39));
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Painel administrativo</h2>
            </div>

            @include('partials.admin.navbar')
        </div>
    </div>
    <div class="main-box">
        <div class="menu-mensagens container">
            <div class="controles">
                <i id="add-btn" class="material-icons">add</i>
            </div>
            <div id="mensagens"></div>
        </div>
        <div class="container">
            <div class="card-body">
                <form method=”POST” action="">
                    <div class="form-group">
                        <textarea class="form-control" name="summernote" id="summernote"></textarea>
                    </div>
                    <button type=”submit” class="btn btn-danger btn-block">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script type="text/javascript">
        document.getElementById('nav-mensagens').classList.add('active');

        $(document).ready(function() {
            $('#summernote').summernote({
                height: 450,
            });

            $.get('{{ route('mensagens.fetch', 'aviso') }}', data => console.log(data))
        });
    </script>
@endsection
