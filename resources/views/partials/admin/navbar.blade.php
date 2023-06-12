<div id="page" class="col-md-12">
    <ul class="nav nav-pills nav-pills-primary" role="tablist" style="display: flex; align-content: flex-start;overflow: scroll;">
        <li id="nav-edicoes">
            <a href="{{ route('administrador') }}">
                <i class="material-icons">adjust</i>
                Edições
            </a>
        </li>
        <li id="nav-escolas">
            <a href="{{ route('administrador.escolas') }}">
                <i class="material-icons">account_balance</i>
                Escolas
            </a>
        </li>
        <li id="nav-niveis">
            <a href="{{ route('administrador.niveis') }}">
                <i class="material-icons">school</i>
                Níveis
            </a>
        </li>
        <li id="nav-areas">
            <a href="{{ route('administrador.areas') }}">
                <i class="material-icons">brightness_auto</i>
                Áreas
            </a>
        </li>
        <li id="nav-fichas">
            <a href="{{ route('administrador.ficha') }}">
                <i class="material-icons">list_alt</i>
                Fichas
            </a>
        </li>
        <li id="nav-tarefas">
            <a href="{{ route('administrador.tarefas') }}">
                <i class="material-icons">title</i>
                Tarefas
            </a>
        </li>
        <li id="nav-mensagens">
            <a href="{{ route('gerenciadorMensagens') }}">
                <i class="material-icons">email</i>
                Mensagens
            </a>
        </li>
        <li id="nav-usuarios">
            <a href="{{ route('administrador.usuarios') }}">
                <i class="material-icons">person</i>
                Participantes
            </a>
        </li>
        <li id="nav-projetos">
            <a href="{{ route('administrador.projetos') }}">
                <i class="material-icons">list_alt</i>
                Listar Projetos
            </a>
        </li>
        <li id="nav-comissao">
            <a href="{{ route('administrador.comissao') }}">
                <i class="material-icons">list_alt</i>
                Comissão Avaliadora
            </a>
        </li>
        <li id="nav-relatorios">
            <a href="{{ route('administrador.relatoriosEdicao') }}">
                <i class="material-icons">description</i>
                Relatórios
            </a>
        </li>
        <li id="nav-configuracoes">
            <a href="{{ route('admin.configuracoes') }}">
                <i class="material-icons">settings</i>
                Configurações
            </a>
        </li>
        <li id="nav-empresas">
            <a href="{{ route('admin.empresas') }}">
                <i class="material-icons">factory</i>
                Empresas
            </a>
        </li>
    </ul>
</div>
