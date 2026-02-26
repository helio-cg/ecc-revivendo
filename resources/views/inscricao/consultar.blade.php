<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Consultar Inscrição - Revivendo ECC</title>

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

<div class="relative z-10 w-full max-w-md bg-white/80 backdrop-blur-xl shadow-2xl rounded-3xl p-8 border border-white/40">

  <div class="text-center mb-8">
    <img src="/img/logo.png" alt="Logo" class="mx-auto w-28 mb-4 drop-shadow-lg">
    <h2 class="text-3xl font-extrabold text-indigo-700">
      Consultar Inscrição
    </h2>
    <p class="text-gray-600 mt-2 text-sm">
      Informe os dados abaixo para localizar sua inscrição
    </p>
  </div>

  @if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl mb-6 text-center font-semibold shadow-sm">
      {{ session('error') }}
    </div>
  @endif

  <form action="{{ route('inscricao.buscar') }}" method="POST" class="space-y-6">
    @csrf

    <!-- Tipo -->
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-3">
        Tipo de inscrição
      </label>

      <div class="grid grid-cols-2 gap-4">

        <label class="cursor-pointer">
          <input type="radio" name="tipo" value="individual" required class="hidden peer">
          <div class="text-center py-3 rounded-xl border border-gray-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 font-semibold transition">
            👤 Individual
          </div>
        </label>

        <label class="cursor-pointer">
          <input type="radio" name="tipo" value="casal" required class="hidden peer">
          <div class="text-center py-3 rounded-xl border border-gray-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 font-semibold transition">
            👩‍❤️‍👨 Casal
          </div>
        </label>

      </div>
    </div>

    <!-- Telefone -->
    <div>
      <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-1">
        Telefone com DDD
      </label>
      <input type="number"
             id="telefone"
             name="telefone"
             placeholder="Ex: 88988887777"
             class="w-full px-4 py-3 rounded-xl border border-gray-300 text-center focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
             required />
    </div>

    <button type="submit"
      class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-300">
      🔍 Buscar Inscrição
    </button>

  </form>
</div>

</body>
</html>