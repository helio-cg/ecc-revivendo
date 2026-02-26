<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Revivendo - ECC</title>

    <!-- Tailwind CDN -->
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

<body class="h-full bg-gradient-to-br from-purple-200 via-blue-100 to-indigo-200 flex items-center justify-center">

<div class="absolute inset-0 bg-white/30 backdrop-blur-3xl"></div>

<div class="relative z-10 w-full max-w-4xl px-6">

    <div class="bg-white/80 backdrop-blur-xl shadow-2xl rounded-3xl p-10 text-center border border-white/40">

        <img src="/img/logo.png" class="mx-auto mb-6 w-32 drop-shadow-lg">

        <h1 class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent mb-4">
            XXIII Revivendo - ECC
        </h1>

        @php
            $hoje = strtotime(now());
            $dataLimite = DateTime::createFromFormat('d/m/Y', '01/08/2026')->getTimestamp();
        @endphp

        @if($hoje > $dataLimite)

            <div class="py-6">
                <h2 class="text-2xl font-bold text-red-600">
                    Inscrições encerradas
                </h2>
            </div>

        @else

            <p class="text-lg font-semibold text-gray-700 mb-2">
                Inscrições abertas até 23/07/2025
            </p>

            <p class="text-gray-600 mb-8">
                Domingo, 03 de Agosto de 2025 <br>
                Iguatu - CE
            </p>

            <div class="grid gap-4 md:grid-cols-2 mb-6">

                <a href="/inscricao"
                   class="group bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold py-4 rounded-xl shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-300">
                    👩‍❤️‍👨 Inscrição CASAL
                </a>

                <a href="/inscricao-individual"
                   class="group bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold py-4 rounded-xl shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-300">
                    🧑 Inscrição INDIVIDUAL
                </a>

            </div>

        @endif

        <a href="/consultar-inscricao"
           class="inline-block mt-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:scale-105 hover:shadow-xl transition-all duration-300">
            🔍 Consultar Inscrição
        </a>

        <!-- Countdown -->
        <div class="mt-10">
            <p class="text-gray-700 font-medium mb-4">
                O evento começa em:
            </p>

            <div id="countdown" class="grid grid-cols-4 gap-4 max-w-md mx-auto text-white font-bold text-lg">
                <div class="bg-indigo-600 rounded-xl py-4 shadow-lg">00d</div>
                <div class="bg-purple-600 rounded-xl py-4 shadow-lg">00h</div>
                <div class="bg-pink-600 rounded-xl py-4 shadow-lg">00m</div>
                <div class="bg-red-500 rounded-xl py-4 shadow-lg">00s</div>
            </div>
        </div>

    </div>
</div>

<script>
    const eventDate = new Date("2026-08-03T08:00:00").getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const timeLeft = eventDate - now;

        if (timeLeft > 0) {
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            const boxes = document.querySelectorAll("#countdown div");
            boxes[0].innerHTML = days + "d";
            boxes[1].innerHTML = hours + "h";
            boxes[2].innerHTML = minutes + "m";
            boxes[3].innerHTML = seconds + "s";
        }
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>

</body>
</html>