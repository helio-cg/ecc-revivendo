<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Inscrição</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #D2CCE6FF, #e3f2fd);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
        }
        .btn-custom {
            background: linear-gradient(135deg, #007bff, #6610f2);
            border: none;
            color: white;
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }
        .btn-custom:hover {
            background: linear-gradient(135deg, #6610f2, #007bff);
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="card p-4 shadow-lg">
        <img src="/img/logo.png">
        <br>
        <h2 class="text-center text-primary fw-bold">Consultar Inscrição</h2>
        <br>
        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('inscricao.buscar') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Telefone:</label>
                <input type="number" name="telefone" class="form-control text-center" placeholder="Somente números 88988887777" required>
            </div>

            <button type="submit" class="btn btn-custom btn-lg w-100">🔍 Buscar</button>
        </form>
    </div>

</body>
</html>
