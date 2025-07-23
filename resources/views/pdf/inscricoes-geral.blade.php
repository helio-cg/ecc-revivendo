<h2>Total de camisas com status pago, costersia e pendente. (CASAIS)</h2>
<table border="1" cellpadding="5" cellspacing="0">
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
