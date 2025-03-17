<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Casais Inscritos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>{{ $paroquia->name }} - {{ $paroquia->city }}</h1>
    <h2>Casais Inscritos</h2>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Camisas</th>
                <th>Incrito em</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscricoes as $inscricao)
                <tr>
                    <td>{{ $inscricao->nome_ele }} ({{ $inscricao->nome_usual_ele }}) <br>{{ $inscricao->nome_ela }} ({{ $inscricao->nome_usual_ela }})</td>
                    <td>{{ $inscricao->telefone }}</td>
                    <td>Ele {{ $inscricao->tamanho_camisa_ele }} | Ela {{ $inscricao->tamanho_camisa_ela }}</td>
                    <td>{{ $inscricao->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
