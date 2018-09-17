@extends('layouts.presenca')

@section('content')
<style>
    body{background: #666;}

    #mensagem{
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        z-index: 10;
    }
    #preview{
        position: relative;
        z-index: 9;
        transform: scaleX(1) !important;

    }

    #QRCode{
        width: 180px;
        height: 180px;
        background: transparent;
        border: 4px solid #FF0000;
        position: fixed;
        z-index: 10;
        left: calc(50vw - 94px);
        top: calc(50vh - 94px);
    }

</style>

<div id="mensagem">

    <div class="alert alert-success" id="success">
        <div class="container-fluid">
            <div class="alert-icon">
                <i class="material-icons">check</i>
            </div>
            Presença Confirmada
        </div>
    </div>

    <div class="alert alert-warning" id="warning">
        <div class="container-fluid">
            <div class="alert-icon">
                <i class="material-icons">warning</i>
            </div>
            Presença já Registrada
        </div>
    </div>

    <div class="alert alert-danger" id="danger">
        <div class="container-fluid">
            <div class="alert-icon">
                <i class="material-icons">error_outline</i>
            </div>
            Erro inesperado.
        </div>
    </div>

</div>

<div id="QRCode"></div>

<video width="100%"style="width: 100vw; height: 100vh;" autoplay id="preview"></video>

@endsection

@section('js')

<script type="text/javascript" src="{{asset('js/instascan.js')}}"></script>
<script type="text/javascript">

    $('#warning').hide();
    $('#success').hide();
    $('#danger').hide();

    setInterval(function () {

        $('#warning').hide();
        $('#success').hide();
        $('#danger').hide();

    },3000);

    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (idPessoa) {

        $.ajax({
            method: "POST",
            url: "{{ route('presenca-sistema') }}",
            data: { id: idPessoa }
        }).done(function( response ) {

            if(response == 'ok'){
                $('#success').show();
            }else{
                $('#warning').show();
            }

            console.log(response);

        }).fail(function () {
            $('#danger').show();
        });

    });
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            console.error('No cameras found.');
        }
    }).catch(function (e) {
        console.error(e);

        $('#danger').hide();
    });
</script>

@endsection
