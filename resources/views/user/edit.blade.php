@extends('layouts.appsemnavbar')

@section('css')
    <link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datepicker/bootstrap-datepicker.standdalone.css') }}" rel="stylesheet">
@endsection
@section('content')
<br>
<br>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12">
                <div class="main main-raised">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h2>Atualizar Cadastro</h2>
                        </div>

                    </div>
                    <form name="f1" method="post" action="{{ route('editaCadastro', $dados->id) }}">

                        {{ csrf_field() }}

                        <div class="row">

                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="col-md-12 text-center">
                                    <h3>Meus Dados</h3>
                                </div>

                                <div class="input-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">face</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nome</label>
                                        <input style="text-transform: capitalize" type="text" class="form-control"
                                            name="nome" value="{{ isset($dados->nome) ? $dados->nome : '' }}" required>
                                    </div>
                                    @if ($errors->has('nome'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                       
                                <div class="input-group {{ $errors->has('genero') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">wc</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Gênero</label>
                                </div>
                                <input type="radio" id="masculino" name="genero" value="M" {{ isset($dados->genero) && $dados->genero === 'M' ? 'checked' : '' }} required>
                                <label style="margin-top:5px; margin-right:15px;">Masculino</label>
                                <input type="radio" id="feminino" name="genero" value="F" {{ isset($dados->genero) && $dados->genero === 'F' ? 'checked' : '' }} required>
                                <label style="margin-left:0px;">Feminino</label>
                                @if ($errors->has('genero'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('genero') }}</strong>
                                    </span>
                                @endif
                            </div>      <div class="input-group{{ $errors->has('cor') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="material-icons">person</i>
                            </span>
                            <div class="form-group">
                                <label class="control-label">Raça/Cor</label>
                                <select id="cor-select" name="cor" value="{{ isset($dados->cor) ? $dados->cor : ''}}" required>
                                    <option value="Amarelo">Amarelo</option>
                                    <option value="Branco">Branco</option>
                                    <option value="Indigena">Indigena</option>
                                    <option value="Pardo">Pardo</option>
                                    <option value="Preto">Preto</option>
                                </select>
                                @if ($errors->has('cor'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cor') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="input-group {{ $errors->has('ehconcluinte') ? 'has-error' : '' }}">
    <span class="input-group-addon">
        <i class="material-icons">school</i>
    </span>
    <div class="form-group label-floating">
        <label class="control-label">É concluinte do Ensino Fundamental ou Ensino Médio,Ensino Médio Técnico?</label>
    </div>
    <input type="radio" name="ehconcluinte" value="s" {{ isset($dados->ehconcluinte) && $dados->ehconcluinte === 's' ? 'checked' : '' }} required>
    <label style="margin-top:5px; margin-right:15px;">sim</label>
    <input type="radio" name="ehconcluinte" value="n" {{ isset($dados->ehconcluinte) && $dados->ehconcluinte === 'n' ? 'checked' : '' }}>
    <label style="margin-left:0px;">não</label>
    @if($errors->has('ehconcluinte'))
    <span class="help-block">
        <strong>{{ $errors->first('ehconcluinte') }}</strong>
    </span>
    @endif
</div>



                            

                                <div class="input-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">call_to_action</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">CPF</label>
                                        <input type="text"
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                            OnKeyPress="formatar('###.###.###-##', this)" maxlength="14"
                                            class="form-control" name="cpf"
                                            value="{{ isset($dados->cpf) ? $dados->cpf : '' }}" required>
                                    </div>
                                    @if ($errors->has('cpf'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cpf') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="input-group{{ $errors->has('dt_nascimento') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">today</i>
                                    </span>
                                    <div class="form-group">
                                        <label class="control-label">Data Nascimento</label>
                                        <input type="text" class="form-control datepicker" name="dt_nascimento"
                                            value="{{ isset($dados->dt_nascimento) ? $dados->dt_nascimento : '' }}"
                                            required>
                                    </div>
                                    @if ($errors->has('dt_nascimento'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('dt_nascimento') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">email</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ isset($dados->email) ? $dados->email : '' }}" required>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="input-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_phone_msg</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Whatssap</label>
                                        <input type="tel" OnKeyPress="formatar('## #####-####', this)"
                                            class="form-control" name="telefone" maxlength="13"
                                            value="{{ $dados->telefone ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('telefone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('telefone') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="input-group{{ $errors->has('camisa') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <img class="gray-icon" src="{{ asset('img/tshirt-crew.svg') }}" />
                                    </span>
                                    <div class="form-group">
                                        <label class="control-label">Camisa</label>
                                        <select id="camisa-select" name="camisa"
                                            value="{{ isset($dados->camisa) ? $dados->camisa : '' }}" required>
                                            <option value="P">P</option>
                                            <option value="M">M</option>
                                            <option value="G">G</option>
                                            <option value="GG">GG</option>
                                            <option value="X1">X1</option>
                                        </select>
                                        @if ($errors->has('camisa'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('camisa') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="input-group{{ $errors->has('senha') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">assignment</i>
                                    </span>
                                    <div class="checkbox news" style="margin-top: 4.5%">
                                        <label>
                                            <span style="margin-right: 5pt;">
                                                Deseja receber informações sobre as novas edições da IFCITEC?
                                            </span>
                                            @if ($dados->newsletter)
                                                <input type="checkbox" name="newsletter" value=true checked>
                                            @else
                                                <input type="checkbox" name="newsletter" value=true>
                                            @endif
                                        </label>
                                    </div>
                                </div>

                                @if ($dados->temFuncao('Avaliador', true) || $dados->temFuncao('Homologador', true))
                                    <div class="input-group{{ $errors->has('titulacao') ? ' has-error' : '' }}">
                                        <span class="input-group-addon">
                                            <i class="material-icons">bookmark</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Titulação Em...</label>
                                            <input type="text" class="form-control" name="titulacao"
                                                value="{{ isset($dados->titulacao) ? $dados->titulacao : '' }}">
                                        </div>
                                        @if ($errors->has('titulacao'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('titulacao') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="input-group{{ $errors->has('lattes') ? ' has-error' : '' }}">
                                        <span class="input-group-addon">
                                            <i class="material-icons">insert_link</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Link Lattes</label>
                                            <input type="url" class="form-control" name="lattes"
                                                value="{{ isset($dados->lattes) ? $dados->lattes : '' }}">
                                        </div>
                                        @if ($errors->has('lattes'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('lattes') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="input-group{{ $errors->has('profissao') ? ' has-error' : '' }}">
                                        <span class="input-group-addon">
                                            <i class="material-icons">assignment_ind</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Profissão</label>
                                            <input type="text" class="form-control" name="profissao"
                                                value="{{ isset($dados->profissao) ? $dados->profissao : '' }}">
                                        </div>
                                        @if ($errors->has('profissao'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('profissao') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="input-group{{ $errors->has('instituicao') ? ' has-error' : '' }}">
                                        <span class="input-group-addon">
                                            <i class="material-icons">school</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Instituição</label>
                                            <input type="text" class="form-control" name="instituicao"
                                                value="{{ isset($dados->instituicao) ? $dados->instituicao : '' }}">
                                        </div>
                                        @if ($errors->has('instituicao'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('instituicao') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/selectize.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datepicker/locales/bootstrap-datepicker.pt-BR.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var oldCamisa = $('#camisa-select').attr("value");
            $('#camisa-select').selectize({
                placeholder: 'Selecione o tamanho...',
                onInitialize: function() {
                    this.setValue(oldCamisa, true);
                    //$('.selectize-control').addClass('form-group');
                    $('.selectize-input').addClass('form-control');
                },
            });
            var oldcor = $('#cor-select').attr("value");
            $('#cor-select').selectize({
                placeholder: 'Selecione o tamanho...',
                onInitialize: function() {
                    this.setValue(oldcor, true);
                    //$('.selectize-control').addClass('form-group');
                    $('.selectize-input').addClass('form-control');
                },
            });
        });

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            templates: {
                leftArrow: '&lsaquo;',
                rightArrow: '&rsaquo;'
            },
        });

        function formatar(mascara, documento) {
            var i = documento.value.length;
            var saida = mascara.substring(0, 1);
            var texto = mascara.substring(i)

            if (texto.substring(0, 1) != saida) {
                documento.value += texto.substring(0, 1);
            }
        }
    </script>
@endsection
