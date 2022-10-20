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

        .delete-btn:hover {
            color: rgb(241, 47, 47);
            cursor: pointer;
            filter: drop-shadow(1pt 2pt 5pt rgba(0, 0, 0, 0.39));
        }

        ul>li>button {
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
    </style>
@endsection

@section('content')
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
                        <button id="goto-emails">
                            <i class="material-icons">email</i>
                            EMAILS
                        </button>
                    </li>
                    <li id="tipo-aviso">
                        <button id="goto-avisos">
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
                    <button onclick="onSave" class="btn btn-danger btn-block">Save</button>
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

        let mensagensCarregadas = [];
        let mensagemAtual = null;

        const mensagemOnClick = (e) => {
            e.preventDefault();

            if (mensagemAtual != null)
                mensagemAtual.element.classList.remove('mensagem-selected');

            const mensagemNome = e.target.firstChild.textContent;
            const mensagem = mensagensCarregadas.find(e => {
                return e.nome === mensagemNome
            });

            mensagemAtual = mensagem;
            mensagem.element.classList.add('mensagem-selected');

            $('#summernote').summernote('reset');
            $('#summernote').summernote('pasteHTML', mensagem.conteudo);
        }

        const onDelete = (e) => {
            e.preventDefault();
            const mensagemNome = e.parentNode.firstChild.textContent;
            const mensagem = mensagensCarregadas.find(e => {
                return e.nome === mensagemNome
            });
        }

        const onSave = (e) => {
            e.preventDefault();
            console.log(e)
        }

        $(document).ready(function() {
            $('#add-btn').click(() => {
                document.getElementById('nova-mensagem').style.display = 'flex';
            });

            $('#confirm-add-btn').click(() => {
                document.getElementById('nova-mensagem').style.display = 'none';
            });

            $('#cancel-add-btn').click(() => {
                document.getElementById('nova-mensagem').style.display = 'none';
            });

            $('#summernote').summernote({
                height: 450,
            });

            $.get('{{ route('mensagens.fetch', 'email') }}', data => {
                data.forEach(e => {

                    const mensagemBox = document.createElement('div');
                    const mensagemNome = document.createElement('div');
                    const deleteIcon = document.createElement('i');

                    mensagemNome.innerHTML = e.nome;

                    deleteIcon.classList.add('material-icons');
                    deleteIcon.classList.add('delete-btn');
                    deleteIcon.innerHTML = 'delete';
                    deleteIcon.onclick = onDelete;

                    mensagemBox.appendChild(mensagemNome);
                    mensagemBox.appendChild(deleteIcon);
                    mensagemBox.onclick = mensagemOnClick;

                    mensagemBox.classList.add('mensagem-box');

                    e.element = mensagemBox;

                    mensagensCarregadas.push(e);
                    document.getElementById('mensagens').appendChild(mensagemBox);
                });
            })
        });
    </script>
@endsection
