<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Revivendo - ECC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e3f2fd);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 500px;
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
    </style>
</head>
<body>

    <div class="container text-center">
        <h1 class="text-primary fw-bold">Revivendo - ECC</h1>
        <p class="text-muted">Bem-vindo ao portal do Encontro de Casais com Cristo.</p>

        <a href="/inscricao" class="btn btn-primary">🚀 Fazer Inscrição</a>
        <a href="/consultar-inscricao" class="btn btn-secondary">🔍 Consultar Inscrição</a>
    </div>

</body>
</html>
