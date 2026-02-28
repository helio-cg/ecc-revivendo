<h2>Resultado</h2>
<p>Tipo: {{ $tipo }}</p>
<p>Paróquia: {{ $inscricao->paroquia->name }}</p>
<p>Telefone: {{ $inscricao->telefone }}</p>
<p>Status: {{ $inscricao->status_pagamento }}</p>

Para mais detalhes, acesse o painel do participante usando o telefone informado. Se houver um boleto gerado, ele estará disponível para pagamento no painel.

@if($inscricao->invoice)
    <p>Valor: {{ $inscricao->invoice->valor }}</p>
    <a href="{{ $inscricao->invoice->invoiceUrl }}" target="_blank">
        Pagar agora
    </a>
@endif