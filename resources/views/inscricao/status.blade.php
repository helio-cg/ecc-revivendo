<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Status da Inscrição</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-100 font-sans flex items-center justify-center p-6">

  <div class="w-full max-w-4xl bg-white/80 backdrop-blur-md shadow-xl rounded-2xl p-6">

    @if(session('success'))
      <div class="bg-green-100 text-green-800 text-center py-2 px-4 rounded mb-4 font-medium">
        {{ session('success') }}
      </div>
    @endif

    <div class="text-center mb-6">
      <h2 class="text-2xl font-bold text-indigo-700">🎉 Status da Inscrição</h2>
    </div>

    <div class="bg-white/80 rounded-xl shadow p-6 text-center mb-6">
      <h3 class="text-xl font-bold text-gray-700">{{ $inscricao->nome_usual_ele }} & {{ $inscricao->nome_usual_ela }}</h3>
      <hr class="my-4">

      <p class="text-lg font-medium text-indigo-700">⛪ {{ $inscricao->paroquia->name }} - {{ $inscricao->paroquia->city }}</p>

      <p class="mt-4"><span class="font-semibold text-indigo-700">👤 Nome completo:</span><br>
        {{ $inscricao->nome_ele }} <br> {{ $inscricao->nome_ela }}
      </p>

      <p class="mt-4"><span class="font-semibold text-indigo-700">📞 Telefone:</span><br>
        {{ '(' . substr($inscricao->telefone, 0, 2) . ') ' . substr($inscricao->telefone, 2, 5) . '-' . substr($inscricao->telefone, 7) }}
      </p>

      <p class="mt-4"><span class="font-semibold text-indigo-700">👕 Camisas:</span><br>
        👨‍🦱 {{ $inscricao->tamanho_camisa_ele }} &nbsp; 👩‍🦰 {{ $inscricao->tamanho_camisa_ela }}
      </p>

      <div class="mt-6">
        <p class="text-lg font-semibold text-indigo-700 mb-2">💰 Status de Pagamento:</p>

        <span class="inline-block px-4 py-2 rounded-lg text-white font-semibold
          {{ ($inscricao->status_pagamento == 'Pago' || $inscricao->status_pagamento == 'Cortesia') ? 'bg-green-500' : 'bg-yellow-500' }}">
          @if($inscricao->status_pagamento == 'Pago' || $inscricao->status_pagamento == 'Cortesia')
            CONFIRMADO
          @else
            {{ ucfirst($inscricao->status_pagamento) }}
          @endif
        </span>
      </div>

      @if ($inscricao->status_pagamento == 'Pendente')
        <div class="mt-6">
          <a href="https://wa.me/5512981026660" target="_blank"
            class="flex items-center justify-center gap-3 px-4 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg shadow transition transform hover:scale-105 w-full max-w-md mx-auto">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" class="w-6 h-6">
            Enviar Comprovante para WhatsApp (12) 98102-6660
          </a>
        </div>
      @endif
    </div>

    @if ($inscricao->status_pagamento == 'Pendente')
      <div class="bg-white/90 backdrop-blur-md rounded-xl shadow-lg p-6 text-center">
        <h2 class="text-2xl font-bold text-red-600 mb-3">💳 Fazer Pagamento</h2>
        <h5 class="text-gray-700">Recebedor:</h5>
        <p class="font-bold text-gray-800">ARTRS SERVIÇOS - R DE SOUZA SERVIÇOS LTDA</p>

        <div class="mt-4">
          <a href="https://mpago.li/1TsuxiV" target="_blank"
            class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow transition transform hover:scale-105">
            🏦 Pagar com Cartão de Crédito/Débito
          </a>
        </div>

        <hr class="my-6">

        <h5 class="text-indigo-700 font-semibold mb-2">📌 Pagar com QR Code Pix</h5>
        <img src="/img/qrcode-pix.jpeg" alt="QR Code Pix"
             class="w-1/2 mx-auto rounded-lg shadow-lg">

        <h5 class="mt-4 text-indigo-700 font-semibold">🔗 Chave Pix - Copia e Cola</h5>
        <div class="bg-yellow-100 text-yellow-800 font-mono text-sm p-4 rounded mt-2 break-words">
          00020101021126580014br.gov.bcb.pix0136dbbbbf12-8086-4567-bcdc-5f43ed158f8a520400005303986540590.005802BR5914ARTRS SERVICOS6009SAO PAULO622905251JPA96XKMYDSVGYXDP5HA7XSH6304ED1D
        </div>

        <a href="{{ route('inscricao.consultar') }}"
           class="inline-block mt-6 text-red-600 font-bold hover:text-red-800 transition transform hover:scale-105">
          ⬅ Voltar
        </a>
      </div>
    @endif

  </div>

</body>
</html>
