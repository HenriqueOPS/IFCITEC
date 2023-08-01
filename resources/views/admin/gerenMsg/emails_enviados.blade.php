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
    <div class="row">
        <div class="col-md-12 text-center">
            <h2>Lista de Emails Enviados com Sucesso Agrupados por Lote</h2>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-md-12 main main-raised">
            <div class="list-projects">
                <!-- Seletor de lotes -->
                <div class="form-group">
                    <label for="filtro-lotes">Filtrar por lote:</label>
                    <select id="filtro-lotes" class="form-control">
                        <option value="todos">Todos</option>
                        @foreach ($lotes as $lote)
                            <option value="{{ $lote }}">{{ $lote }}</option>
                        @endforeach
                    </select>
                </div>

                <table class="table" id="tabela-emails">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Lote</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Horário de Envio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emailsEnviados as $i => $emailEnviado)
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $emailEnviado->lote }}</td>
                            <td>{{ $emailEnviado->email }}</td>
                            <td>
                                @if ($emailEnviado->status)
                                    <span class="badge badge-success">Enviado com sucesso</span>
                                @else
                                    <span class="badge badge-danger">Não enviado</span>
                                @endif
                            </td>
                            <td>{{ $emailEnviado->horario_envio }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')

<style>
    .badge-success {
        background-color: #28a745;
    }

    .badge-danger {
        background-color: #dc3545;
    }
</style>


@endsection

@section('js')
 
    <script>
        document.getElementById('nav-escolas').classList.add('active');
        
document.addEventListener('DOMContentLoaded', function() {
    // Obtém o elemento <select> de filtrar por lote
    const filtroLotes = document.getElementById('filtro-lotes');

    // Obtém a tabela de emails
    const tabelaEmails = document.getElementById('tabela-emails');

    // Evento para quando o seletor de filtrar por lote for alterado
    filtroLotes.addEventListener('change', function() {
        // Obtém o valor selecionado no seletor
        const valorSelecionado = filtroLotes.value;

        // Obtém todas as linhas da tabela, exceto a primeira (cabeçalho)
        const linhasTabela = tabelaEmails.querySelectorAll('tbody tr');

        // Loop através das linhas da tabela e exibe apenas as que correspondem ao lote selecionado
        for (let i = 0; i < linhasTabela.length; i++) {
            const colunaLote = linhasTabela[i].getElementsByTagName('td')[1]; // Coluna de lote (índice 1)

            if (valorSelecionado === 'todos' || (colunaLote && colunaLote.innerText === valorSelecionado)) {
                linhasTabela[i].style.display = ''; // Exibe a linha
            } else {
                linhasTabela[i].style.display = 'none'; // Oculta a linha
            }
        }
    });

    // Inicializa a tabela exibindo todos os emails
    filtroLotes.value = 'todos';
    filtroLotes.dispatchEvent(new Event('change'));
});

    </script>
@endsection