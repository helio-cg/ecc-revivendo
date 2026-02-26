<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Status da Inscrição - Revivendo ECC</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>

<body class="h-full bg-gradient-to-br from-indigo-200 via-blue-100 to-purple-200 flex items-center justify-center p-6">

<div class="absolute inset-0 bg-white/30 backdrop-blur-3xl"></div>

<div class="relative z-10 w-full max-w-5xl bg-white/80 backdrop-blur-xl shadow-2xl rounded-3xl p-8 md:p-12 border border-white/40">

  @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl mb-6 text-center font-semibold shadow-sm">
      {{ session('success') }}
    </div>
  @endif

  <!-- Título -->
  <div class="text-center mb-10">
    <h2 class="text-3xl md:text-4xl font-extrabold text-indigo-700">
      🎉 Status da Inscrição
    </h2>
  </div>

  <!-- Card Principal -->
  <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-8 text-center mb-8">

    <h3 class="text-2xl font-bold text-gray-800">
      {{ $inscricao->nome_usual_ele }} & {{ $inscricao->nome_usual_ela }}
    </h3>

    <div class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto my-6 rounded-full"></div>

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

    @if ($inscricao->status_pagamento == 'Pendente')
      <div class="mt-8">
        <a href="https://wa.me/5512981026660" target="_blank"
           class="inline-flex items-center justify-center gap-3 px-6 py-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg transition transform hover:scale-105">
          💬 Enviar Comprovante pelo WhatsApp
        </a>
      </div>
    @endif

  </div>

  <!-- PAGAMENTO -->
  @if ($inscricao->status_pagamento == 'Pendente')
  <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-8 text-center">

    <h2 class="text-2xl font-extrabold text-red-600 mb-4">
      💳 Finalizar Pagamento
    </h2>

    <p class="text-gray-700">
      Recebedor:
    </p>

    <p class="font-bold text-gray-800 mb-6">
      ARTRS SERVIÇOS - R DE SOUZA SERVIÇOS LTDA
    </p>

    <a href="https://mpago.li/1TsuxiV" target="_blank"
       class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition transform hover:scale-105 mb-8">
      🏦 Pagar com Cartão
    </a>

    <div class="border-t pt-8">

      <h5 class="text-indigo-700 font-semibold mb-4">
        📌 Pagar com QR Code Pix
      </h5>

      <img src="/img/qrcode-pix.jpeg"
           class="w-56 mx-auto rounded-xl shadow-xl mb-6">

      <h5 class="text-indigo-700 font-semibold mb-2">
        🔗 Chave Pix (Copia e Cola)
      </h5>

      <div class="bg-yellow-100 text-yellow-800 font-mono text-xs md:text-sm p-4 rounded-xl break-words shadow-inner">
        00020101021126580014br.gov.bcb.pix0136dbbbbf12-8086-4567-bcdc-5f43ed158f8a520400005303986540590.005802BR5914ARTRS SERVICOS6009SAO PAULO622905251JPA96XKMYDSVGYXDP5HA7XSH6304ED1D
      </div>

      <a href="{{ route('inscricao.consultar') }}"
         class="inline-block mt-8 text-red-600 font-bold hover:text-red-800 transition transform hover:scale-105">
        ⬅ Voltar
      </a>

    </div>

  </div>
  @endif

</div>

</body>
</html>