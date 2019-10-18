@extends('layouts.app')

@section('content')
<br><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    @if($p == 1)
                    <div class="col-md-10 col-md-offset-1">
                        <h2 style="text-align: center">A presença do seu projeto está confirmada!</h2>
                    </div>
                    @else
                    <div class="col-md-10 col-md-offset-1">
                        <h2 style="text-align: center">A confirmação de presença não foi possível pois o seu projeto não foi homologado!</h2>
                    </div>
                    @endif

					<div class="col-md-10 col-md-offset-1 text-center" style="margin-top: 50px;">
						<a href="{{route('autor')}}" class="confirma btn btn-success">
							<i class="material-icons">bookmarks</i> Ir para Projetos
						</a>
					</div>
                </div>
                <br><br><br>
            </div>
        </div>
    </div>
</div>
</body>
@endsection

