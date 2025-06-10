<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Revivendo - ECC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #D2CCE6FF, #e3f2fd);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #ff7f50, #ff4500);
            border: none;
            color: white;
            font-weight: bold;
            padding: 14px;
            font-size: 1.2rem;
            transition: 0.3s ease-in-out;
            display: block;
            width: 100%;
            margin-bottom: 10px;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #ff4500, #ff7f50);
            transform: scale(1.07);
            box-shadow: 0px 4px 10px rgba(255, 69, 0, 0.3);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #007bff, #6610f2);
            border: none;
            color: white;
            font-weight: bold;
            padding: 12px;
            font-size: 1rem;
            transition: 0.3s ease-in-out;
            display: block;
            width: 100%;
            border-radius: 8px;
        }
        .btn-secondary:hover {
            background: linear-gradient(135deg, #6610f2, #007bff);
            transform: scale(1.05);
        }
        #countdown {
            font-size: 2rem;
            font-weight: bold;
            color: #6610f2;
        }
    </style>
</head>
<body>

    <div class="container text-center">
        <img src="/img/logo.png">
        <h1 class="text-primary fw-bold">XXII Revivendo - ECC</h1>
        <br>
        <p class="text-muted">Nosso encontro será realizado domingo<br>03 de agosto de 2025 na cidade de Iguatu-CE</p>
        <br>
        <a href="/inscricao" class="btn btn-primary">👩‍❤️‍👨 Fazer Inscrição CASAL</a>
        <br>
        <a href="/inscricao-individual" class="btn btn-primary">🧑 Fazer Inscrição INDIVIDUAL</a>
        <br>
        <a href="/consultar-inscricao" class="btn btn-secondary">🔍 Consultar Inscrição</a>
        <br>
        <p>O evento começa em:</p>
        <div id="countdown">00d 00h 00m 00s</div>
    </div>



    <script>
        // Defina a data do evento (AAAA, MM, DD, HH, MM, SS)
        const eventDate = new Date("2025-08-03T08:00:00").getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = eventDate - now;

            if (timeLeft > 0) {
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else {
                document.getElementById("countdown").style.display = "none";
                document.querySelector(".event-message").style.display = "block";
                clearInterval(interval);
            }
        }

        updateCountdown(); // Atualiza imediatamente ao carregar a página
        const interval = setInterval(updateCountdown, 1000);
    </script>
</body>
</html>
