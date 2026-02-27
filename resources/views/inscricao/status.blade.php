<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
  <meta charset="UTF-8">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center p-4 font-sans">

<div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden">

  <!-- HEADER -->
  <div class="bg-indigo-600 text-white text-center p-6">
    <img src="/img/logo.png" class="mx-auto w-20 mb-2">
    <h1 class="text-2xl font-bold">Comprovante de Inscrição</h1>
    <p class="text-sm opacity-80">Evento Revivendo ECC</p>
  </div>

  <!-- DADOS -->
  <div class="p-6 space-y-5">

    <!-- INFO GERAL -->
    <div class="flex justify-between text-sm">
      <span class="text-gray-500">Nº do comprovante</span>
      <span class="font-bold">#{{ $inscricao->id }}</span>
    </div>

    <div class="flex justify-between text-sm">
      <span class="text-gray-500">Data</span>
      <span>{{ now()->format('d/m/Y H:i') }}</span>
    </div>

    <hr class="border-dashed">

    <!-- CASAL -->
    <div class="text-center">
      <h2 class="text-xl font-bold text-gray-800">
        {{ $inscricao->nome_usual_ele }} & {{ $inscricao->nome_usual_ela }}
      </h2>

      <p class="text-indigo-700 font-semibold mt-2">
        ⛪ {{ $inscricao->paroquia->name }} - {{ $inscricao->paroquia->city }}
      </p>
    </div>

    <hr class="border-dashed">

    <!-- DETALHES -->
    <div class="grid grid-cols-2 gap-4 text-sm">

      <div>
        <p class="text-gray-500">Nome completo</p>
        <p>{{ $inscricao->nome_ele }}</p>
        <p>{{ $inscricao->nome_ela }}</p>
      </div>

      <div>
        <p class="text-gray-500">Telefone</p>
        <p>
          {{ '(' . substr($inscricao->telefone,0,2) . ') ' . substr($inscricao->telefone,2,5) . '-' . substr($inscricao->telefone,7) }}
        </p>
      </div>

      <div>
        <p class="text-gray-500">Camisas</p>
        <p>👨 {{ $inscricao->tamanho_camisa_ele }}</p>
        <p>👩 {{ $inscricao->tamanho_camisa_ela }}</p>
      </div>

      <div>
        <p class="text-gray-500">Status</p>
        @if($inscricao->status_pagamento == 'Pago' || $inscricao->status_pagamento == 'Cortesia')
          <p class="text-green-600 font-bold">PAGAMENTO CONFIRMADO ✅</p>
        @else
          <p class="text-yellow-600 font-bold">PAGAMENTO PENDENTE ⏳</p>
        @endif
      </div>

    </div>

    <!-- PIX -->
    @if ($inscricao->status_pagamento == 'Pendente')
    <div class="text-center mt-6">


      -Clique aqui para fazer pagamento

      <p class="text-xs text-gray-400 mt-2">
        A confirmação é automática após o pagamento.
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