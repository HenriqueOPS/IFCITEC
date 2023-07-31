@extends('layouts.app')

@section('css')
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css");

        .menu-mensagens {
            width: 30%;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            padding: 0%;
        }

        .controles {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            width: 100%;
        }

        .nova-mensagem {
            display: flex;
            flex-direction: row;
            align-items: center;
            background-color: white;
        }

        .nova-mensagem>input {
            outline: none;
            border-bottom: 1pt black solid;
        }

        .nova-mensagem>#confirm-add-btn {
            color: white;
            background-color: #1a237e;
            outline: none;
            border: none;
        }

        .nova-mensagem>#cancel-add-btn {
            color: white;
            background-color: rgb(241, 47, 47);
            outline: none;
            border: none;
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

        .mensagem-box {
            transition: all 0.1s;
            display: flex;
            flex-direction: row;
            width: 98%;
            margin-top: 15px;
            padding: 2%;
            height: 40px;
            background-color: white;
            align-items: center;
            justify-content: space-between;
          
        }

        .mensagem-box:hover {
            filter: drop-shadow(1pt 1pt 4pt rgba(0, 0, 0, 0.39));
            cursor: pointer;
        }

        .mensagem-selected {
            background-color: #1a237e;
            color: white;
        }

        .mensagem-body {
            width: 93%;
        }

        .delete-btn {
            width: 5%;
            margin-right: 2%;
        }

        .delete-btn:hover {
            color: rgb(241, 47, 47);
            cursor: pointer;
            filter: drop-shadow(1pt 2pt 5pt rgba(0, 0, 0, 0.39));
        }

        #mensagens {
            background-color: whitesmoke;
            width: 95%;
            height: 96%;
            overflow: scroll;
        }

        #add-btn {
            align-self: flex-end;
            transition: 0.1s all;
            background-color: white;
            width: 95%;
            text-align: center;
        }

        #add-btn:hover {
            filter: drop-shadow(1pt 2pt 5pt rgba(0, 0, 0, 0.39));
        }

        ul>li>button {
            transition: all 0.2s;
            background-color: transparent;
            color: #555555;
            border: none;
            padding: 6pt 20pt !important;
            font-weight: 500;
            font-size: 12px;
        }

        ul>li>button:hover {
            background-color: rgba(200, 200, 200, 0.2);
        }

        .tipo-selected {
            background-color: #1a237e;
            color: white;
            box-shadow: 0 16px 26px -10px rgba(26, 35, 126, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(26, 35, 126, 0.2);
        }

        .tipo-selected>button {
            color: white;
        }
    </style>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ Session::token() }}">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Painel administrativo</h2>
            </div>

            @include('partials.admin.navbar')

            <div id="page" class="col-md-12">
                <ul class="nav nav-pills nav-pills-primary" role="tablist"
                    style="display: flex; align-content: center; justify-content: center;">
                    <li id="tipo-email">
                        <button id="goto-emails" data-nome="email" class="tipo-btn">
                            <i class="material-icons">email</i>
                            EMAILS
                        </button>
                    </li>
                    <li id="tipo-aviso">
                        <button id="goto-avisos" data-nome="aviso" class="tipo-btn">
                            <i class="material-icons">warning</i>
                            AVISOS
                        </button>
                    </li>
                    <li id="tipo-instagram">
                        <button id="goto-instagram" data-nome="instagram" class="tipo-btn" >
                        <i class="bi bi-instagram"></i>
                            INSTAGRAM
                        </button>
                    </li>
                      <li id="tipo-envio">
                        <button id="goto-envio" data-nome="envio" class="tipo-btn" >
                        <i class="material-icons">schedule_send</i>
                            ENVIO
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <section>
        <div class="main-box">
            <div class="menu-mensagens container"  >
                <div class="controles">
                    <div id="add-btn" class="material-icons" style="cursor: pointer;">add</div>
                    <div class="nova-mensagem" id="nova-mensagem" style="display: none;">
                        <label for="mensagem-input">Nome: </label>
                        <input type="text" name="mensagem-input" id="mensagem-input">
                        <button id="confirm-add-btn" class="material-icons">check</button>
                        <button id="cancel-add-btn" class="material-icons">close</button>
                    </div>
                </div>
                <div id="mensagens"></div>
            </div>
            <div class="container">
                <div class="card-body">
                    <div id="summernote"></div>
                    <button id="summernote-save" class="btn btn-danger btn-block">Salvar</button>
                </div>
            </div>
            <div class="container" id="container-envio" style="display: none;">
            <div id="quadro-geral">
            <h2>Geral</h2>
            <div>
                <input type="checkbox" id="participantes" name="funcoesgerais[]" value="Participantes">
                <label for="participantes">Participantes</label>
            </div>
            <div>
                <input type="checkbox" id="escolas" name="funcoesgerais[]" value="Escolas">
                <label for="escolas">Escolas</label>
            </div>
            <div>
                <input type="checkbox" id="homologadores" name="funcoesgerais[]" value="Homologadores">
                <label for="homologadores">Homologadores</label>
            </div>
            <div>
                <input type="checkbox" id="avaliadores" name="funcoesgerais[]" value="Avaliadores">
                <label for="avaliadores">Avaliadores</label>
            </div>
        </div>

        <div id="quadro-edicao-corrente">
            <h2>Edição Corrente</h2>
            <div>
                <input type="checkbox" id="autores" name="funcoesedicao[]" value="Autor">
                <label for="autores">Autores</label>
            </div>
            <div>
                <input type="checkbox" id="orientadores" name="funcoesedicao[]" value="Orientador">
                <label for="orientadores">Orientadores</label>
            </div>
            <div>
                <input type="checkbox" id="coorientadores" name="funcoesedicao[]" value="Coorientador">
                <label for="coorientadores">Coorientadores</label>
            </div>
            <div>
                <input type="checkbox" id="homologadores-edicao" name="funcoesedicao[]" value="Homologador">
                <label for="homologadores-edicao">Homologadores</label>
            </div>
            <div>
                <input type="checkbox" id="avaliadores-edicao" name="funcoesedicao[]" value="Avaliador">
                <label for="avaliadores-edicao">Avaliadores</label>
            </div>
            <div>
                <input type="checkbox" id="voluntarios" name="funcoesedicao[]" value="Voluntário">
                <label for="voluntarios">Voluntários</label>
            </div>
            <div>
                <input type="checkbox" id="Administrador" name="funcoesedicao[]" value="Administrador">
                <label for="Administrador">Administrador</label>
            </div>
        </div>


            <div>
                <button class="btn btn-danger btn-block" id="botao-envio">Enviar</button>
            </div>
        </div>

                </div>
    </section>
@endsection

@section('js')
    <!-- summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script type="text/javascript">
        document.getElementById('nav-mensagens').classList.add('active');

        const postHeaders = {
            _token: $('meta[name=csrf-token]').attr('content'),
        };

        let mensagensCarregadas = [];
        let mensagemAtual = null;
        let tipoAtual = '';
        function tipoOnClick(e) {
            e.preventDefault();

            const tipos = document.getElementsByClassName('tipo-btn');
            for (let i = 0; i < tipos.length; i++) {
                tipos[i].parentNode.classList.remove('tipo-selected');
            }

            console.log(e.target.parentNode.parentNode)

            if (e.target.localName === 'i') {
                tipoAtual = e.target.parentNode.dataset.nome;     
                e.target.parentNode.parentNode.classList.add('tipo-selected');
            } else {
                tipoAtual = e.target.dataset.nome;  
                e.target.parentNode.classList.add('tipo-selected');
            }


            fetchMensagens();
        }

        const tipos = document.getElementsByClassName('tipo-btn');
        for (let i = 0; i < tipos.length; i++) {
            tipos[i].addEventListener('click', tipoOnClick);
        }
        document.getElementById('goto-envio').addEventListener('click', envioemail);
       
        function envioemail() {
            const containerEnvio = document.getElementById('container-envio');
            if (containerEnvio) {
                containerEnvio.style.display = this.id === 'goto-envio' ? 'block' : 'none';
            }
        }

        // Vincule a função envioemail a todos os botões "goto-..."
        const gotoButtons = document.querySelectorAll('[id^="goto-"]');
        gotoButtons.forEach(button => {
            button.addEventListener('click', envioemail);
        });

        const mensagemOnClick = (e) => {
            e.preventDefault();

            trocarMensagemSelecionada(e);
            mostrarMensagemSelecionada();
        }

        const onDelete = (e) => {
            e.preventDefault();
            const mensagemNome = e.target.parentNode.firstChild.textContent;
            const mensagem = mensagensCarregadas.find(e => {
                return e.nome === mensagemNome
            });

            if (mensagem === mensagemAtual)
                $('#summernote').summernote('reset');

            let url = "{{ route('mensagens.delete', ':id') }}";
            url = url.replace(':id', mensagem.id);
            $.post(url, postHeaders).then(() => fetchMensagens());
        }

        $(document).ready(function() {

            $('#add-btn').click(() => {
                document.getElementById('nova-mensagem').style.display = 'flex';
            });

            $('#confirm-add-btn').click(() => {
                const input = document.getElementById('mensagem-input');

                if (input.value == null)
                    return;

                let url = "{{ route('mensagens.create', ['nome' => ':nome', 'tipo' => ':tipo']) }}";
                url = url.replace(':nome', input.value);
                url = url.replace(':tipo', tipoAtual);

                $.post(url, postHeaders).then(() => fetchMensagens());

                document.getElementById('nova-mensagem').style.display = 'none';
                input.value = '';
            });

            $('#cancel-add-btn').click(() => {
                document.getElementById('nova-mensagem').style.display = 'none';
            });
      

            $('#summernote-save').click((e) => {
                if (mensagemAtual === null)
                    return;

                let url = "{{ route('mensagens.save') }}";

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _token: $('meta[name=csrf-token]').attr('content'),
                        id: mensagemAtual.id,
                        conteudo: utf8_to_b64($('#summernote').summernote('code'))
                    },
                    dataType: 'json',
                    success: function(response) {
                    // Manipule a resposta JSON aqui
                    if (response.mensagem) {
                        // Exiba a mensagem de sucesso ao usuário
                        alert(response.mensagem);
                        $('#summernote').summernote('reset');
                        fetchMensagens();
                    }   
        },
                    error: data => {
                        const dd = document.createElement('div');
                        document.getElementById('app').appendChild(dd);
                        dd.innerHTML = data.responseText;
                    }
                });
            });

            $('#summernote').summernote({
                height: 450,
                dialogsInBody: true,
            });
            $('#botao-envio').click((e) => {
            if (mensagemAtual === null)
                return;

            let url = "{{ route('mensagens.enviar')}}";

            // Obter os valores selecionados dos checkboxes
            let funcoesgerais = $('input[name="funcoesgerais[]"]:checked').map(function () {
                return $(this).val();
            }).get();
            let funcoesedicao = $('input[name="funcoesedicao[]"]:checked').map(function () {
                return $(this).val();
            }).get();
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _token: $('meta[name=csrf-token]').attr('content'),
                    id: mensagemAtual.id,
                    conteudo: utf8_to_b64($('#summernote').summernote('code')),
                    funcoesgerais: funcoesgerais,
                    funcoesedicao: funcoesedicao // Enviar os valores selecionados dos checkboxes
                },
                success: function(response) {
                    // Manipule a resposta JSON aqui
                    if (response.mensagem) {
                        // Exiba a mensagem de sucesso ao usuário
                        alert(response.mensagem);
                    }
                },
                dataType: 'json',
                error: data => {
                    const dd = document.createElement('div');
                    document.getElementById('app').appendChild(dd);
                    dd.innerHTML = data.responseText;
                }
            });
        });
            
            fetchMensagens();
        });

        function trocarMensagemSelecionada(mensagemClicada) {
            if (mensagemAtual != null)
                mensagemAtual.element.classList.remove('mensagem-selected');

            const mensagemNome = mensagemClicada.target.firstChild.textContent;
            const mensagem = mensagensCarregadas.find(e => {
                return e.nome === mensagemNome
            });

            mensagemAtual = mensagem;
            mensagem.element.classList.add('mensagem-selected');
        }

        function mostrarMensagemSelecionada() {
            if (mensagemAtual == null)
                return;

            $('#summernote').summernote('reset');
            if (mensagemAtual.conteudo != null)
                $('#summernote').summernote('pasteHTML', mensagemAtual.conteudo);
        }

        function fetchMensagens() {
            document.getElementById('mensagens').innerHTML = '';
            mensagensCarregadas = [];

            let url = "{{ route('mensagens.fetchByType', ':tipo') }}";
            url = url.replace(':tipo', tipoAtual);

            $.get(url, data => {
                data.forEach(e => {

                    const mensagemBox = document.createElement('div');
                    const mensagemBody = document.createElement('div');
                    const mensagemNome = document.createElement('div');
                    const deleteIcon = document.createElement('i');

                    mensagemNome.innerHTML = e.nome;

                    deleteIcon.classList.add('material-icons');
                   

                    mensagemBox.appendChild(mensagemBody);
                    mensagemBox.appendChild(deleteIcon);

                    mensagemBody.onclick = mensagemOnClick;
                    mensagemBody.appendChild(mensagemNome);
                    mensagemBody.classList.add('mensagem-body');

                    mensagemBox.classList.add('mensagem-box');

                    e.element = mensagemBox;

                    mensagensCarregadas.push(e);
                    document.getElementById('mensagens').appendChild(mensagemBox);
                });
            }).then(() => {
                const mensagemAtualRecarregada = mensagensCarregadas.find(e =>
                    e.nome === mensagemAtual.nome && e.tipo === mensagemAtual.tipo
                );

                mensagemAtual = mensagemAtualRecarregada;

                if (mensagemAtual != undefined) {
                    mensagemAtual.element.classList.add('mensagem-selected');
                    mostrarMensagemSelecionada();
                }
            });
        }

        function b64_to_utf8(str) {
            return decodeURIComponent(escape(window.atob(str)));
        }

        function utf8_to_b64(str) {
            return window.btoa(unescape(encodeURIComponent(str)));
        }
    </script>
@endsection
