<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sorteio - Casais</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 8px;
            color: #333;
        }

        h1 {
            color: #2c3e50;
            font-size: 26px;
            margin-bottom: 4px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .ticket {
            width: 100%;
            border-collapse: collapse;
            border: 2px dashed #2c3e50;
            background: #fff;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .ticket .num {
            width: 60px;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            color: #fff;
            background: #2c3e50;
            border-right: 2px solid #2c3e50;
            padding: 4px 8px;
        }

        .ticket .nome {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            padding: 4px 10px;
            border-bottom: 1px solid #eee;
        }

        .ticket .paroquia {
            font-size: 12px;
            color: #555;
            padding: 4px 10px;
        }

        .espaco {
            height: 14px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Sorteio - {{ $titulo }}</h1>
    <p class="subtitle">Casais com pagamento <b style="color: green;">Pago</b> ({{ count($inscricoes) }} participantes)</p>
    @foreach ($inscricoes as $inscricao)
        <table class="ticket">
            <tr>
                <td class="num">{{ $loop->iteration }}</td>
                <td>
                    <div class="nome">{{ $inscricao->nome_ele }} ({{ $inscricao->nome_usual_ele }}) &amp; {{ $inscricao->nome_ela }} ({{ $inscricao->nome_usual_ela }})</div>
                    <div class="paroquia">{{ $inscricao->paroquia->name }} - {{ $inscricao->paroquia->city }}</div>
                </td>
            </tr>
        </table>
        @if (!$loop->last)
            <div class="espaco"></div>
        @endif
    @endforeach
    <p class="footer">Total de participantes: {{ count($inscricoes) }}</p>
</body>
</html>
