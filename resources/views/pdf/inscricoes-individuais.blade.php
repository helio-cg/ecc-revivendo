<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Inscritos Individuais</title>
    <style>
        /* Estilos gerais */
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 4px;
            line-height: 1.6;
            color: #333;
        }

        /* Cabeçalho */
        h1 {
            color: #2C5526FF;
            font-size: 28px;
            margin-bottom: 5px;
            border-bottom: 2px solid #25A121FF;
            padding-bottom: 5px;
        }

        h2 {
            color: #25A121FF;
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
            background: #25A121FF;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 2px 4px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
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
            margin: 2px 0;
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

        tr:nth-child(even) { /* Linhas pares */
            background-color: #f8f9fa; /* Cinza claro */
        }

        tr:nth-child(odd) { /* Linhas ímpares */
            background-color: #ffffff; /* Branco */
        }
        .cam{
            background-color: #f8f9fa; /* Cinza claro */
            border: 2px solid #25A121FF;
            padding: 4px;
        }

    </style>
</head>
<body>
    <h1>{{ $paroquia->name }} - {{ $paroquia->city }}</h1>
    <h2>Camisas</h2>
    <div class="cam">
    @foreach ($resultado as $tamanho => $quantidade)
        @if ($quantidade > 0)
            <b>{{ $tamanho }}</b>: {{ $quantidade }} {{ $quantidade == 1 ? 'camisa' : 'camisas' }} -
        @endif
    @endforeach
    @if ($total > 0)
        <b>Total:</b> {{ $total }} {{ $total == 1 ? 'camisa' : 'camisas' }}
    @else
        Nenhuma camisa registrada.
    @endif
    </div>
    <h2>Inscrições Individuais</h2>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Camisas</th>
                <th>Status</th>
                <th>Inscrito em</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscricoes as $inscricao)
                <tr>
                    <td>
                        <span class="couple-name">{{ $inscricao->nome }} <span class="usual-name">(<b>{{ $inscricao->nome_usual }}</b>)</span></span>
                    </td>
                    <td style="padding-top: 4px;">{{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $inscricao->telefone) }}</td>
                    <td style="padding-top: 4px;">
                        <span class="shirt-size">{{ $inscricao->tamanho_camisa }}</span>
                    </td>
                    <td>{{ $inscricao->status_pagamento }}</td>
                    <td>{{ $inscricao->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>