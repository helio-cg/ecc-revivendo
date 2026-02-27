<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center p-4 font-sans">

<div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden">

    <!-- HEADER -->
    <div class="bg-indigo-600 text-white p-6 text-center">
        <img src="/img/logo.png" class="mx-auto w-20 mb-2">
        <h1 class="text-2xl font-bold">Comprovante de Inscrição</h1>
        <p class="text-sm opacity-80">Evento Revivendo</p>
    </div>

    <!-- DADOS -->
    <div class="p-6 space-y-4">

        <div class="flex justify-between text-sm">
            <span class="text-gray-500">Nº do comprovante</span>
            <span class="font-bold">#{{ $inscricao->id }}</span>
        </div>

        <div class="flex justify-between text-sm">
            <span class="text-gray-500">Data</span>
            <span>{{ now()->format('d/m/Y H:i') }}</span>
        </div>

        <hr class="border-dashed">

        <div>
            <p class="text-gray-500 text-sm">Participante</p>
            <p class="font-bold text-lg">{{ $inscricao->nome }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Telefone</p>
                <p>
                {{ '(' . substr($inscricao->telefone,0,2) . ') ' . substr($inscricao->telefone,2,5) . '-' . substr($inscricao->telefone,7) }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Camisa</p>
                <p>{{ $inscricao->tamanho_camisa }}</p>
            </div>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Paróquia</p>
            <p class="font-semibold">
                {{ $inscricao->paroquia->name }} - {{ $inscricao->paroquia->city }}
            </p>
        </div>

        <hr class="border-dashed">

        <!-- STATUS -->
        <div class="text-center mt-4">

            @if($inscricao->status_pagamento == 'Pago' || $inscricao->status_pagamento == 'Cortesia')
                <p class="text-green-600 text-2xl font-bold">PAGAMENTO CONFIRMADO ✅</p>
            @else
                <p class="text-yellow-600 text-xl font-bold">PAGAMENTO PENDENTE</p>
            @endif

        </div>

        <!-- PIX -->
        @if($inscricao->status_pagamento == 'Pendente')
        <div class="text-center mt-6">

            Clique pra fazer pagamento

            {{-- <img src="{{ $qrCode }}" class="mx-auto w-40"> --}}

            <p class="text-xs mt-2 text-gray-400">
                Após o pagamento a confirmação é automática
            </p>
        </div>
        @endif

    </div>

    <!-- FOOTER -->
    <div class="bg-gray-50 text-center text-xs text-gray-500 p-4">
        Este comprovante foi gerado automaticamente pelo sistema.
        Em caso de dúvidas, entre em contato com a organização do evento.
    </div>

</div>

</body>
</html>