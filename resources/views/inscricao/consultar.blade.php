<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Consultar Inscrição</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center p-6">

  <div class="w-full max-w-md bg-white/80 backdrop-blur-md shadow-2xl rounded-xl p-6">
    <div class="text-center mb-6">
      <img src="/img/logo.png" alt="Logo" class="mx-auto w-28 mb-4">
      <h2 class="text-2xl font-bold text-indigo-700">Consultar Inscrição</h2>
    </div>

    @if(session('error'))
      <div class="bg-red-100 text-red-800 text-center p-3 rounded mb-4 font-medium">
        {{ session('error') }}
      </div>
    @endif

    <form action="{{ route('inscricao.buscar') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block font-semibold text-gray-700 mb-1">Tipo:</label>
        <div class="flex gap-4">
          <label class="flex items-center space-x-2">
            <input type="radio" id="individual" name="tipo" value="individual" required class="accent-indigo-500">
            <span>Individual</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="radio" id="casal" name="tipo" value="casal" required class="accent-indigo-500">
            <span>Casal</span>
          </label>
        </div>
      </div>

      <div>
        <label for="telefone" class="block font-semibold text-gray-700 mb-1">Telefone:</label>
        <input type="number"
               id="telefone"
               name="telefone"
               placeholder="Somente números 88988887777"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-indigo-400"
               required />
      </div>

      <button type="submit"
              class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-indigo-600 hover:to-blue-600 text-white font-bold py-3 rounded-lg shadow-md transition transform hover:scale-105">
        🔍 Buscar
      </button>
    </form>
  </div>

</body>
</html>
