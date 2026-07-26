<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Total Geral de Casais</title>
    <style>
        body { font-size: 10px; margin: 4px; font-family: Arial, sans-serif; }
        h2 { font-size: 13px; margin: 4px 0; }
        table { width: 100%; border-collapse: collapse; font-size: 9px; }
        th, td { padding: 2px 4px; border: 1px solid #999; }
        th { background: #3498db; color: white; font-size: 9px; }
    </style>
</head>
<body>
<h2>Total de camisas - <span style="color: green;">Pago</span> e <span style="color: #e67e22;">Cortesia</span> (CASAIS)</h2>
<table>
    <thead>
        <tr>
            <th>Paróquia</th>
            <th>Cidade</th>
            @foreach ($tamanhos as $t)
                <th>{{ $t }}</th>
            @endforeach
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tabela as $linha)
            <tr>
                <td>{{ $linha['paroquia'] }}</td>
                <td>{{ $linha['cidade'] }}</td>
                @foreach ($tamanhos as $t)
                    <td align="center">{{ $linha['dados'][$t] }}</td>
                @endforeach
                <td align="center"><strong>{{ $linha['dados']['total'] }}</strong></td>
            </tr>
        @endforeach
        <tr style="font-weight: bold; background: #f0f0f0">
            <td colspan="2">Total Geral</td>
            @foreach ($tamanhos as $t)
                <td align="center">{{ $totalGeral[$t] }}</td>
            @endforeach
            <td align="center">{{ $totalGeral['total'] }}</td>
        </tr>
    </tbody>
</table>
</body>
</html>
