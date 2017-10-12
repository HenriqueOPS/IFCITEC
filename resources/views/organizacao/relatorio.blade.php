<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        td{
            border-bottom: 1px solid black;
        }
    </style>
</head>
<body>
<h1>Usuário</h1>
    <table style="width:100%">
        <tr>
            <th>Nome</th>
            <th>Email</th>
        </tr>
        @foreach( $usuarios as $usuario)
        <tr>
            <td>{{$usuario->nome}}</td>
            <td>{{$usuario->email}}</td>
        </tr>
        @endforeach
    </table>

<h1>Avaliador</h1>
<table style="width:100%">
    <tr>
        <th>Nome</th>
        <th>Email</th>
    </tr>
    @foreach( $avaliadores as $avaliador)
        <tr>
            <td>{{$avaliador->nome}}</td>
            <td>{{$avaliador->email}}</td>
        </tr>
    @endforeach
</table>

<h1>Revisor</h1>
<table style="width:100%">
    <tr>
        <th>Nome</th>
        <th>Email</th>
    </tr>
    @foreach( $revisores as $revisor)
        <tr>
            <td>{{$revisor->nome}}</td>
            <td>{{$revisor->email}}</td>
        </tr>
    @endforeach
</table>
</body>
</html>