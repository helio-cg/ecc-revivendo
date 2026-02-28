<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inscrição Individual - Revivendo ECC</title>

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

<body class="h-full bg-gradient-to-br from-indigo-200 via-blue-100 to-purple-200 flex items-center justify-center p-4">

<div class="absolute inset-0 bg-white/30 backdrop-blur-3xl"></div>

<div class="relative z-10 w-full max-w-6xl bg-white/80 backdrop-blur-xl shadow-2xl rounded-3xl overflow-hidden flex flex-col md:flex-row border border-white/40">

  <!-- LADO ESQUERDO -->
  <div class="hidden md:flex md:w-2/5 relative items-center justify-center bg-gradient-to-br from-indigo-600 to-purple-700 p-10 text-white">

    <div class="absolute inset-0 bg-black/20"></div>

    <div class="relative z-10 text-center">
      <img src="/img/logo.png" class="w-40 mx-auto mb-8 drop-shadow-xl">

      <h2 class="text-3xl font-extrabold mb-4">
        XXIII Revivendo
      </h2>

      <p class="text-indigo-100 mb-8">
        Inscrição individual para viúvos do ECC
      </p>

      <img src="/img/camisa.jpeg" class="w-72 rounded-2xl shadow-2xl mx-auto hover:scale-105 transition duration-500">
    </div>
  </div>

  <!-- FORM -->
  <div class="w-full md:w-3/5 p-8 md:p-12">

    <h2 class="text-3xl font-extrabold text-indigo-700 mb-2 text-center">
      Inscrição Individual
    </h2>

    <p class="text-center text-gray-600 mb-6">
      Preencha seus dados com atenção
    </p>

    @if(session('success'))
      <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl mb-6 text-center font-semibold shadow-sm">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
        <ul class="list-disc list-inside text-sm space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('inscricao-individual.store') }}" method="POST" class="space-y-6">
      @csrf

      <div>
        <label class="block text-sm font-semibold mb-1">Nome completo</label>
        <input type="text" name="nome"
          class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
          value="{{ old('nome') }}">
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
          <label class="block text-sm font-semibold mb-1">Nome usual</label>
          <input type="text" name="nome_usual"
            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition"
            value="{{ old('nome_usual') }}">
        </div>

        <div>
          <label class="block text-sm font-semibold mb-1">Tamanho da camisa</label>
          <select name="tamanho_camisa"
            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition">
            <option value="">Selecione</option>
            @foreach (['PP','P','M','G','GG','EXG','EXGG'] as $tamanho)
              <option value="{{ $tamanho }}" {{ old('tamanho_camisa') == $tamanho ? 'selected' : '' }}>
                {{ $tamanho }}
              </option>
            @endforeach
          </select>
        </div>

      </div>

      <div>
        <label class="block text-sm font-semibold mb-1">
          Telefone com DDD
          <span class="text-red-500 text-xs">(Somente números)</span>
        </label>
        <input type="text" name="telefone" id="telefone" required
          class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition"
          value="{{ old('telefone') }}"
          placeholder="(88) 9 9999-9999">
        <script>
          document.getElementById('telefone').addEventListener('input', function (e) {
              let v = e.target.value.replace(/\D/g, '');

              if (v.length > 11) v = v.slice(0,11);

              if (v.length <= 10) {
                  v = v.replace(/(\d{2})(\d)/, "($1) $2")
                      .replace(/(\d{4})(\d)/, "$1-$2");
              } else {
                  v = v.replace(/(\d{2})(\d)/, "($1) $2")
                      .replace(/(\d{5})(\d)/, "$1-$2");
              }

              e.target.value = v;
          });
          </script>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1">Paróquia</label>
        <select name="paroquia_id"
          class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition">
          <option value="">Selecione uma paróquia</option>
          @foreach ($paroquias as $paroquia)
            <option value="{{ $paroquia->id }}" {{ old('paroquia_id') == $paroquia->id ? 'selected' : '' }}>
              {{ $paroquia->name }} - {{ $paroquia->city }}
            </option>
          @endforeach
        </select>
      </div>

      <button type="submit"
        class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-300">
        📩 Enviar Inscrição
      </button>

    </form>
  </div>
</div>

</body>
</html>