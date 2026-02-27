<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status da Inscrição</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-100 font-sans flex items-center justify-center p-4">

<div class="w-full max-w-3xl bg-white/80 backdrop-blur-md  rounded-xl p-6 sm:p-8">

    {{-- ALERTA SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 text-center py-2 px-4 rounded mb-6 font-medium shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- TÍTULO --}}
    <div class="text-center mb-8">
        <img src="/img/logo.png" class="mx-auto w-24 mb-3" alt="Logo">
        <h1 class="text-3xl font-bold text-indigo-700">🎉 Status da Inscrição</h1>
        <p class="text-gray-600 text-sm">Confira os dados da sua inscrição</p>
    </div>

    {{-- PAGAMENTO PIX --}}
    @if ($inscricao->status_pagamento == 'Pendente')

        <div class="bg-white/90 backdrop-blur-md rounded-xl p-6 text-center mb-6">

            <h2 class="text-2xl font-bold text-red-600 mb-3">💳 Fazer Pagamento</h2>

            <p>Clique aqui pra fazer pagamento</p>

            <a href="{{ route('inscricao.consultar') }}"
                class="inline-block mt-8 text-red-600 font-bold hover:text-red-800 transition transform hover:scale-105">
                ⬅ Voltar
            </a>

        </div>

    @endif

    {{-- CARD DADOS --}}
    <div class="bg-white/90 rounded-xl p-6 text-center mb-6">

        <h3 class="text-2xl font-bold text-gray-800">
            {{ $inscricao->nome_usual }}
        </h3>

        <hr class="my-4">

        <p class="text-indigo-700 font-semibold text-lg">
            ⛪ {{ $inscricao->paroquia->name }} - {{ $inscricao->paroquia->city }}
        </p>

        <div class="mt-4 text-gray-700">
            <p class="font-semibold text-indigo-700">👤 Nome completo</p>
            <p>{{ $inscricao->nome }}</p>
        </div>

        <div class="mt-4 text-gray-700">
            <p class="font-semibold text-indigo-700">📞 Telefone</p>
            <p>
                {{ '(' . substr($inscricao->telefone,0,2) . ') ' . substr($inscricao->telefone,2,5) . '-' . substr($inscricao->telefone,7) }}
            </p>
        </div>

        <div class="mt-4 text-gray-700">
            <p class="font-semibold text-indigo-700">👕 Camisa</p>
            <p>{{ $inscricao->tamanho_camisa }}</p>
        </div>

        {{-- STATUS PAGAMENTO --}}
        <div class="mt-6">
            <p class="text-lg font-semibold text-indigo-700 mb-2">💰 Status de Pagamento</p>

            <span class="inline-block px-5 py-2 rounded-lg text-white font-bold shadow
                {{ ($inscricao->status_pagamento == 'Pago' || $inscricao->status_pagamento == 'Cortesia') ? 'bg-green-500' : 'bg-yellow-500' }}">

                @if($inscricao->status_pagamento == 'Pago' || $inscricao->status_pagamento == 'Cortesia')
                    CONFIRMADO ✅
                @else
                    {{ ucfirst($inscricao->status_pagamento) }}
                @endif
            </span>
        </div>



    </div>



</div>



</body>
</html>