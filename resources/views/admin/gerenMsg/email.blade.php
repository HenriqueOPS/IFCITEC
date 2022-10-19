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
            flex-direction: row;
            align-items: center;
            justify-content: flex-end;
            width: 100%;
            height: 4%;
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
        }

        #mensagens {
            background-color: whitesmoke;
            width: 95%;
            height: 96%;
            overflow: scroll;
        }

        #add-btn {
            transition: 0.1s all;
            background-color: white;
            width: 95%;
            text-align: center;
        }

        #add-btn:hover {
            filter: drop-shadow(1pt 2pt 5pt rgba(0, 0, 0, 0.39));
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
        </div>
    </div>
    <div class="main-box">
        <div class="menu-mensagens container">
            <div class="controles">
                <i id="add-btn" class="material-icons">add</i>
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
@endsection

@section('js')
    <!-- summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script type="text/javascript">
        document.getElementById('nav-mensagens').classList.add('active');

        let mensagensCarregadas = [];

        const mensagemOnClick = (e) => {
            e.preventDefault();
            const mensagemNome = e.target.firstChild.textContent;
            const mensagem = mensagensCarregadas.find(e => {
                return e.nome === mensagemNome
            });

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
                    deleteIcon.innerHTML = 'delete';
                    deleteIcon.onclick = onDelete;

                    mensagemBox.appendChild(mensagemNome);
                    mensagemBox.appendChild(deleteIcon);
                    mensagemBox.onclick = mensagemOnClick;

                    mensagemBox.classList.add('mensagem-box');

                    document.getElementById('mensagens').appendChild(mensagemBox);
                });

                mensagensCarregadas = data;
            })
        });
    </script>
@endsection
