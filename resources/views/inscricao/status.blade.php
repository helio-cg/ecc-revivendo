<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Status da Inscrição - Revivendo ECC</title>

  <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-100 font-sans flex items-center justify-center p-4">


<div class="w-full max-w-3xl bg-white/80 backdrop-blur-md rounded-xl p-6 sm:p-8">

  @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl mb-6 text-center font-semibold shadow-sm">
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
        <div class="bg-white/90 backdrop-blur-md rounded-xl  p-6 text-center mb-6">
            <h2 class="text-2xl font-bold text-red-600 mb-3">💳 Fazer Pagamento</h2>

            <p>Clique aqui pra fazer pagamento</p>

            <a href="{{ route('inscricao.consultar') }}"
                class="inline-block mt-8 text-red-600 font-bold hover:text-red-800 transition transform hover:scale-105">
                ⬅ Voltar
            </a>
        </div>
    @endif

  <!-- Card Principal -->
    <div class="bg-white/90 rounded-xl p-6 text-center mb-6">

    <h3 class="text-2xl font-bold text-gray-800">
      {{ $inscricao->nome_usual_ele }} & {{ $inscricao->nome_usual_ela }}
    </h3>

    <hr class="my-4">

    <p class="text-lg font-semibold text-indigo-700">
      ⛪ {{ $inscricao->paroquia->name }} - {{ $inscricao->paroquia->city }}
    </p>

    <div class="mt-6 space-y-4 text-gray-700">

      <div>
        <span class="font-semibold text-indigo-700">👤 Nome completo</span><br>
        {{ $inscricao->nome_ele }} <br>
        {{ $inscricao->nome_ela }}
      </div>

      <div>
        <span class="font-semibold text-indigo-700">📞 Telefone</span><br>
        {{ '(' . substr($inscricao->telefone, 0, 2) . ') ' . substr($inscricao->telefone, 2, 5) . '-' . substr($inscricao->telefone, 7) }}
      </div>

      <div>
        <span class="font-semibold text-indigo-700">👕 Camisas</span><br>
        👨 {{ $inscricao->tamanho_camisa_ele }} &nbsp;&nbsp;
        👩 {{ $inscricao->tamanho_camisa_ela }}
      </div>

    </div>

    <!-- STATUS -->
    <div class="mt-8">
      <p class="text-lg font-semibold text-indigo-700 mb-3">
        💰 Status de Pagamento
      </p>

      <span class="inline-block px-6 py-3 rounded-full text-white font-bold text-sm tracking-wide shadow-lg
        {{ ($inscricao->status_pagamento == 'Pago' || $inscricao->status_pagamento == 'Cortesia') ? 'bg-green-500' : 'bg-yellow-500' }}">

        @if($inscricao->status_pagamento == 'Pago' || $inscricao->status_pagamento == 'Cortesia')
          ✔ CONFIRMADO
        @else
          ⏳ {{ ucfirst($inscricao->status_pagamento) }}
        @endif
      </span>
    </div>
  </div>

</div>
</body>
</html>