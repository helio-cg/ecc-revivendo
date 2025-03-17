<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Casais Inscritos</title>
    <style>
        /* Estilos gerais */
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
            color: #333;
        }

        /* Cabeçalho */
        h1 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 5px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }

        h2 {
            color: #2980b9;
            font-size: 22px;
            margin: 20px 0 15px;
        }

        /* Tabela */
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background: #3498db;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        tr:hover {
            background: #f1faff;
            transition: background 0.2s;
        }

        /* Estilização específica */
        .couple-name {
            display: block;
            margin: 4px 0;
        }

        .usual-name {
            color: #666;
            font-size: 0.9em;
        }

        .shirt-size {
            display: inline-block;
            margin-right: 10px;
            padding: 2px 6px;
            background: #e9ecef;
            border-radius: 4px;
        }
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
                <th>Inscrito em</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscricoes as $inscricao)
                <tr>
                    <td>
                        <span class="couple-name">{{ $inscricao->nome_ele }} <span class="usual-name">({{ $inscricao->nome_usual_ele }})</span></span>
                        <span class="couple-name">{{ $inscricao->nome_ela }} <span class="usual-name">({{ $inscricao->nome_usual_ela }})</span></span>
                    </td>
                    <td>{{ $inscricao->telefone }}</td>
                    <td>
                        <span class="shirt-size">Ele {{ $inscricao->tamanho_camisa_ele }}</span>
                        <span class="shirt-size">Ela {{ $inscricao->tamanho_camisa_ela }}</span>
                    </td>
                    <td>{{ $inscricao->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>