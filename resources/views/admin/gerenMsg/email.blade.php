@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Painel administrativo</h2>
            </div>

            @include('partials.admin.navbar')
        </div>
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
@endsection

@section('js')
    <!-- summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        document.getElementById('nav-mensagens').classList.add('active');

        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endsection
