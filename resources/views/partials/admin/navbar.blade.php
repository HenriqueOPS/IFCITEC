<div id="page" class="col-md-12" style="display: flex; justify-content: center;">
    <ul class="nav nav-pills nav-pills-primary" role="tablist" style="display: flex; align-items: center;">
        <li class="nav-item dropdown" style="margin: 0px 5px 0px 0px;">
            <a class="nav-link dropdown-toggle" href="#" id="dropdownAdministrativa" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-symbols-outlined">admin_panel_settings</i>
                Administrativa
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownAdministrativa">
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('administrador.areas') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">brightness_auto</i>
                    Áreas / Níveis
                </a></li>
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('admin.configuracoes') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">settings</i>
                    Configurações
                </a></li>
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('admin.brindes') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">shopping_bag</i>
                    Premiação
                </a></li>
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('administrador') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">adjust</i>
                    Edições
                </a></li>
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('administrador.tarefas') }}">
                        <i class="material-icons" style="display: flex; justify-content: center;">title</i>
                        Tarefas
                    </a>
                </li>
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('admin.cursos') }}">
                    <i class="material-symbols-outlined" style="display: flex; justify-content: center;">school</i>
                    Cursos
                </a></li>
            </ul>
        </li>
        <li class="nav-item dropdown" style="margin: 0px 5px 0px 5px;">
            <a class="nav-link dropdown-toggle" href="#" id="dropdownParticipantes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons" style="display: flex; justify-content: center;">person</i>
                Participantes
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownParticipantes">
                <li><a class="dropdown-item" href="{{ route('admin.empresas') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">factory</i>
                    Empresas
                </a></li>
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('administrador.escolas') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">account_balance</i>
                    Escolas
                </a></li>
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('administrador.usuarios') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">person</i>
                    Usuários
                </a></li>
            </ul>
        </li>
        <li class="nav-item dropdown" style="margin: 0px 0px 0px 5px;">
            <a class="nav-link dropdown-toggle" href="#" id="dropdownComissoes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-symbols-outlined" style="display: flex; justify-content: center;">group</i>
                Comissões
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownComissoes">
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('administrador.comissao') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">list_alt</i>
                    Comissão Avaliadora
                </a></li>
            </ul>
        </li>
        <li class="nav-item dropdown" style="margin: 0px 0px 0px 5px;">
            <a class="nav-link dropdown-toggle" href="#" id="dropdownComunicacoes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-symbols-outlined" style="display: flex; justify-content: center;">mail</i>
                Comunicações
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownComunicacoes">
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('emails-enviados') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">ballot</i>
                    Mensagens Enviadas
                </a></li>
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('gerenciadorMensagens') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">email</i>
                    Mensagens
                </a></li>
            </ul>
        </li>
        <li class="nav-item dropdown" style="margin: 0px 0px 0px 5px;">
            <a class="nav-link dropdown-toggle" href="#" id="dropdownProjetos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons" style="display: flex; justify-content: center;">school</i>
                Projetos
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownProjetos">
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('administrador.projetos') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">list_alt</i>
                    Listar Projetos
                </a></li>
                <li><a class="dropdown-item" style="text-decoration: none;" href="{{ route('administrador.ficha') }}">
                    <i class="material-icons" style="display: flex; justify-content: center;">list_alt</i>
                    Fichas de avaliação
                </a></li>
            </ul>
        </li>
        <li class="nav-item" id="nav-relatorios" style="margin: 0px 0px 0px 5px;">
            <a class="nav-link" href="{{ route('administrador.relatoriosEdicao') }}">
                <i class="material-icons" style="display: flex; justify-content: center;">description</i>
                Relatórios
            </a>
        </li>
    </ul>    
</div>
