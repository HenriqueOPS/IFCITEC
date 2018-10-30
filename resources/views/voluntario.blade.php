@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
<style>
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; top: 0; }
.se-pre-con {
    position: fixed;
    left: 520px;
    top: 350px;
    width: 3%;
    height: 3%;
    z-index: 1;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <h2>Cadastro de Voluntário</h2>
                    </div>
                </div>

                <div class="row hide" id="loadCadastro">
                    <div class="loader loader--style2" title="1">
                        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="80px" height="80px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                          <path fill="#000" d="M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z">
                              <animateTransform attributeType="xml"
                                                attributeName="transform"
                                                type="rotate"
                                                from="0 25 25"
                                                to="360 25 25"
                                                dur="0.6s"
                                                repeatCount="indefinite"/>
                          </path>
                          </svg>
                    </div>

                </div>

                <div class="panel-body">
                <form method="POST" id="cadastraVoluntario" action="{{route('cadastraVoluntario')}}">

                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info text-center">
                                <div class="container-fluid">
                                    <div class="alert-icon">
                                        <i class="material-icons">info_outline</i>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                    </button>
                                    <b>ATENÇÃO: </b>Você receberá mais informações em breve!
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button name="button" href="javascript:void(0);" class="btn btn-primary">Inscrever</button>

                            </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function () {

    let frm = $('#cadastraVoluntario');

    frm.submit(function(event) {

        $('#loadCadastro').removeClass('hide');

    });
});
</script>
@endsection

