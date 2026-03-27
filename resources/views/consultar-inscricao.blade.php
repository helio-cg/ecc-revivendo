<!DOCTYPE html>
<html>
<head>
    <title>Consultar Inscrição</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center p-4 font-sans">

<div class="w-full max-w-xl bg-white rounded-2xl shadow-xl overflow-hidden p-6">

    <!-- HEADER -->
    <div class="bg-indigo-600 text-white p-6 text-center mb-10">
        <img src="/img/logo.png" class="mx-auto w-20 mb-2">
        <h1 class="text-2xl font-bold">Consultar Inscrição</h1>
        <p class="text-sm opacity-80">{{ config('app.name') }}</p>
    </div>

    @if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl mb-6 text-center font-semibold shadow-sm">
      {{ session('error') }}
    </div>
  @endif

    <form id="formConsulta" class="space-y-4">

         <!-- Telefone -->
    <div>
      <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-1">
        Telefone com DDD
      </label>
      <input type="number"
             id="telefone"
             name="telefone"
             placeholder="Ex: 88988887777 (apeanas números)"
             class="w-full px-4 py-3 rounded-xl border border-gray-300 text-center focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
             required />
    </div>

        <button
            type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-lg"
        >
            Consultar
        </button>

    </form>

</div>

<script>
document.getElementById('formConsulta').addEventListener('submit', function(e) {
    e.preventDefault();

    let telefone = document.getElementById('telefone').value.replace(/\D/g, '');

    window.location.href = "/consultar-inscricao/" + telefone;
});
</script>

</body>
</html>