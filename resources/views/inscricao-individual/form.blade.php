<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inscrição no Evento</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-linear-to-br from-indigo-100 to-blue-100 flex items-center justify-center p-4">

  <div class="backdrop-blur-md bg-white/80 shadow-xl rounded-2xl w-full max-w-5xl overflow-hidden flex flex-col md:flex-row">

    <!-- Lado esquerdo - Imagem -->
    <div class="hidden md:flex flex-col items-center justify-center bg-cover bg-center bg-no-repeat bg-gray-200 md:w-2/5 p-6" style="background-image: url('https://via.placeholder.com/450')">
      <img src="/img/logo.png" alt="Logo" class="w-40 mb-8">
      <img src="/img/camisa.jpeg" alt="Camisa" class="w-80 rounded-lg shadow-md">
    </div>

    <!-- Lado direito - Formulário -->
    <div class="w-full md:w-3/5 p-8">
      <h2 class="text-center text-indigo-700 text-2xl font-bold mb-4">Inscrição para XXII Revivendo - ECC</h2>
      <hr class="mb-4">

      @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center font-medium">
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
          <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('inscricao-individual.store') }}" method="POST">
        @csrf

        <div class="mb-4">
          <label class="block font-semibold mb-1">Nome completo:</label>
          <input type="text" name="nome" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('nome') }}">
        </div>

        <div class="flex gap-4">
          <div class="w-1/2 mb-4">
            <label class="block font-semibold mb-1">Nome usual (apelido):</label>
            <input type="text" name="nome_usual" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('nome_usual') }}">
          </div>
          <div class="w-1/2 mb-4">
            <label class="block font-semibold mb-1">Tamanho da camisa:</label>
            <select name="tamanho_camisa" class="w-full border border-gray-300 rounded px-3 py-2">
              <option value="">Selecione um opção</option>
              @foreach (['PP','P','M','G','GG','EXG','EXGG'] as $tamanho)
                <option value="{{ $tamanho }}" {{ old('tamanho_camisa', $tamanho_camisa ?? '') == $tamanho ? 'selected' : '' }}>{{ $tamanho }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="mb-4">
          <label class="block font-semibold mb-1">Telefone com DDD: <span class="text-red-600 text-sm">(Somente números)</span></label>
          <input type="number" name="telefone" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('telefone') }}" required>
        </div>

        <div class="mb-6">
          <label class="block font-semibold mb-1">Paróquia:</label>
          <select name="paroquia_id" class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="">Selecione uma paróquia</option>
            @foreach ($paroquias as $paroquia)
              <option value="{{ $paroquia->id }}" {{ old('paroquia_id', $paroquia_id ?? '') == $paroquia->id ? 'selected' : '' }}>
                {{ $paroquia->name }} - {{ $paroquia->city }}
              </option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="w-full py-3 bg-linear-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:scale-105 transition transform duration-300 ease-in-out shadow-md">
          📩 Enviar Inscrição
        </button>
      </form>
    </div>
  </div>

</body>
</html>
