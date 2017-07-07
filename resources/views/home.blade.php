@extends('layouts.app')
@section('content')
<body style="background-image: url(https://scontent.fpoa1-1.fna.fbcdn.net/v/t35.0-12/19250192_943481775794342_1136829307_o.png?oh=7b0380547fb3f88dd318ac6e4055213e&oe=5947BF13); background-position: absolute; background-size: cover">
    <br><br>
    <div class="container" style="width: 600px; height: 350px; background-color: #eeeeee; border-radius: 10px 20px;">
        <div class="row">
            <div class="col-md-12 col-md-offset-4">
                <h2>Voluntário</h2><br><br>
            </div>
            <form method="POST" action="{{url('/cadastraVoluntario')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                        <center> <button class="btn">
                            <i class="material-icons">directions_run</i> Quero Ser Voluntário
                        </button></center>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection