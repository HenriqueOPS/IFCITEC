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
    <br><br>
    <div class="container">
        Oi
    </div>
@endsection

@section('js')
<script>
    document.getElementById('nav-mensagens').classList.add('active');
</script>
@endsection
