<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição no Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #D2CCE6FF, #e3f2fd);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .row {
            display: flex;
            align-items: center;
        }
        .image-section {
            background: url('https://via.placeholder.com/450') no-repeat center center/cover;
            min-height: 100%;
        }
        .form-section {
            padding: 30px;
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
        .error-list {
            color: #dc3545;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <!-- Lado esquerdo - Imagem -->
        <div class="col-md-5 d-none d-md-block image-section">
            <br>
            <img src="/img/logo.png">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <img src="/img/camisa.jpeg" width="380px">
        </div>

        <!-- Lado direito - Formulário -->
        <div class="col-md-7 form-section">
            <h2 class="text-center text-primary fw-bold">Inscrição para XXII Revivendo - ECC</h2>
            <hr>

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('inscricao-individual.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Nome completo:</label>
                    <input type="text" name="nome" class="form-control" value="{{ old('nome') }}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nome usual (apelido):</label>
                        <input type="text" name="nome_usual" class="form-control" value="{{ old('nome_usual') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tamanho da camisa:</label>
                        <select class="form-select" name="tamanho_camisa">
                            <option value="">Selecione um opção</option>
                            <option value="PP" {{ old('tamanho_camisa', $tamanho_camisa ?? '') == 'PP' ? 'selected' : '' }}>PP</option>
                            <option value="P" {{ old('tamanho_camisa', $tamanho_camisa ?? '') == 'P' ? 'selected' : '' }}>P</option>
                            <option value="M" {{ old('tamanho_camisa', $tamanho_camisa ?? '') == 'M' ? 'selected' : '' }}>M</option>
                            <option value="G" {{ old('tamanho_camisa', $tamanho_camisa ?? '') == 'G' ? 'selected' : '' }}>G</option>
                            <option value="GG" {{ old('tamanho_camisa', $tamanho_camisa ?? '') == 'GG' ? 'selected' : '' }}>GG</option>
                            <option value="EXG" {{ old('tamanho_camisa', $tamanho_camisa ?? '') == 'EXG' ? 'selected' : '' }}>EXG</option>
                            <option value="EXGG" {{ old('tamanho_camisa', $tamanho_camisa ?? '') == 'EXGG' ? 'selected' : '' }}>EXGG</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Telefone com DDD: <span class="text-danger">(Somente números)</span></label>
                    <input type="number" name="telefone" class="form-control" value="{{ old('telefone') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Paróquia:</label>
                    <select class="form-control" name="paroquia_id">
                        <option value="">Selecione uma paróquia</option>
                        @foreach ($paroquias as $paroquia)
                            <option value="{{ $paroquia->id }}" {{ old('paroquia_id', $paroquia_id ?? '') == $paroquia->id ? 'selected' : '' }}>{{ $paroquia->name }} - {{ $paroquia->city }} </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-custom btn-lg w-100 mt-3">📩 Enviar Inscrição</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
