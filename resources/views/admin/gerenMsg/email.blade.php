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
            margin: 1%;
            padding: 2%;
            height: 5%;
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
                </ul>
            </div>
        </div>
    </div>

    <section>
        <div class="main-box">
            <div class="menu-mensagens container">
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
                    <button id="summernote-save" class="btn btn-danger btn-block">Save</button>
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
            contentType: "text/html; charset=utf-8"
        };

        let mensagensCarregadas = [];
        let mensagemAtual = null;

        let tipoAtual = '';

        function tipoOnClick(e) {
            e.preventDefault();
            tipoAtual = e.target.dataset.nome;

            const tipos = document.getElementsByClassName('tipo-btn');
            for (let i = 0; i < tipos.length; i++) {
                tipos[i].parentNode.classList.remove('tipo-selected');
            }

            e.target.parentNode.classList.add('tipo-selected');

            fetchMensagens();
        }

        const tipos = document.getElementsByClassName('tipo-btn');
        for (let i = 0; i < tipos.length; i++) {
            tipos[i].addEventListener('click', tipoOnClick);
        }

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

                let url = "{{ route('mensagens.save') }}" +
                    `?id=${mensagemAtual.id}` +
                    `&conteudo=${$('#summernote').summernote('code')}`;

                console.log(url);
                $.post(url, postHeaders, r => console.log(r)).then(() => fetchMensagens());
            });

            $('#summernote').summernote({
                height: 450,
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

            let url = "{{ route('mensagens.fetch', ':tipo') }}";
            url = url.replace(':tipo', tipoAtual);

            $.get(url, data => {
                data.forEach(e => {

                    const mensagemBox = document.createElement('div');
                    const mensagemBody = document.createElement('div');
                    const mensagemNome = document.createElement('div');
                    const deleteIcon = document.createElement('i');

                    mensagemNome.innerHTML = e.nome;

                    deleteIcon.classList.add('material-icons');
                    deleteIcon.classList.add('delete-btn');
                    deleteIcon.innerHTML = 'delete';
                    deleteIcon.onclick = onDelete;

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
    </script>
@endsection
