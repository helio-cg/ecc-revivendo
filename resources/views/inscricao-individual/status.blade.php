<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status da Inscrição</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-100 font-sans flex items-center justify-center p-4">

<div class="w-full max-w-3xl bg-white/80 backdrop-blur-md shadow-2xl rounded-2xl p-6 sm:p-8">

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

    {{-- CARD DADOS --}}
    <div class="bg-white/90 rounded-xl shadow-lg p-6 text-center mb-6">

        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
            {{ $inscricao->nome_usual }}
        </h2>

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

        {{-- BOTÃO WHATSAPP --}}
        @if ($inscricao->status_pagamento == 'Pendente')
            <div class="mt-6">
                <a href="https://wa.me/5512981026660?text=Olá,%20envio%20comprovante%20da%20inscrição%20{{ urlencode($inscricao->nome_usual) }}"
                   target="_blank"
                   class="flex items-center justify-center gap-3 px-4 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg shadow transition transform hover:scale-105 w-full max-w-md mx-auto">

                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" class="w-6 h-6" alt="WhatsApp">
                    Enviar Comprovante no WhatsApp
                </a>
            </div>
        @endif

    </div>

    {{-- PAGAMENTO PIX --}}
    @if ($inscricao->status_pagamento == 'Pendente')

        <div class="bg-white/90 backdrop-blur-md rounded-xl shadow-lg p-6 text-center">

            <h2 class="text-2xl font-bold text-red-600 mb-3">💳 Fazer Pagamento</h2>

            <p class="text-gray-600">Recebedor</p>
            <p class="font-bold text-gray-800 mb-4">
                ARTRS SERVIÇOS - R DE SOUZA SERVIÇOS LTDA
            </p>

            <hr class="my-6">

            <h3 class="text-indigo-700 font-semibold mb-2">📌 QR Code Pix</h3>

            <img src="/img/qr-individual.jpeg"
                 class="w-52 mx-auto rounded-lg shadow-lg mb-4">

            <h3 class="text-indigo-700 font-semibold mb-2">🔗 Pix Copia e Cola</h3>

            <div id="pixcode"
                 class="bg-yellow-100 text-yellow-900 font-mono text-xs p-4 rounded break-words select-all">
00020101021126580014br.gov.bcb.pix0136dbbbbf12-8086-4567-bcdc-5f43ed158f8a520400005303986540545.005802BR5914ARTRS SERVICOS6009SAO PAULO622905251JXCYFH205EWT8FN5PK738FR46304FA0E
            </div>

            <button onclick="copyPix()"
                class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg shadow">
                📋 Copiar Código Pix
            </button>

            <a href="{{ route('inscricao.consultar') }}"
               class="block mt-6 text-red-600 font-bold hover:text-red-800">
               ⬅ Voltar para Consulta
            </a>

        </div>

    @endif

</div>

<script>
function copyPix() {
    const text = document.getElementById('pixcode').innerText;
    navigator.clipboard.writeText(text);
    alert('Código Pix copiado!');
}
</script>

</body>
</html>