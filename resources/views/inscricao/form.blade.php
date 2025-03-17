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
        .card {
            border: none;
            border-radius: 12px;
            max-width: 700px;
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
        .error-list {
            color: #dc3545;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="card p-4 shadow-lg">
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

        <form action="{{ route('inscricao.store') }}" method="POST">
            @csrf

            <h5 class="text-primary fw-bold">Dados ELE</h5>
            <div class="row rounded-3 mb-3">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Nome completo:</label>
                    <input type="text" name="nome_ele" class="form-control" value="{{ old('nome_ele') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nome usual (apelido):</label>
                    <input type="text" name="nome_usual_ele" class="form-control" value="{{ old('nome_usual_ele') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tamanho da camisa:</label>
                    <select class="form-select" name="tamanho_camisa_ele" aria-label="Tamanho da camisa" value="{{ old('tamanho_camisa_ele') }}">
                        <option selected value="">Selecione um opção</option>
                        <option value="PP">PP</option>
                        <option value="P">P</option>
                        <option value="M">M</option>
                        <option value="G">G</option>
                        <option value="GG">GG</option>
                        <option value="EXG">EXG</option>
                      </select>
                </div>
            </div>

            <h5 class="text-danger fw-bold">Dados ELA</h5>
            <div class="row rounded-3">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Nome completo:</label>
                    <input type="text" name="nome_ela" class="form-control" value="{{ old('nome_ela') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nome usual (apelido):</label>
                    <input type="text" name="nome_usual_ela" class="form-control" value="{{ old('nome_usual_ela') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tamanho da camisa:</label>
                    <select class="form-select" name="tamanho_camisa_ela" aria-label="Tamanho da camisa" value="{{ old('tamanho_camisa_ela') }}">
                        <option selected value="">Selecione um opção</option>
                        <option value="PP">PP</option>
                        <option value="P">P</option>
                        <option value="M">M</option>
                        <option value="G">G</option>
                        <option value="GG">GG</option>
                        <option value="EXG">EXG</option>
                    </select>
                </div>
            </div>


            <div class="mb-3 mt-3">
                <label class="form-label fw-bold">Telefone com DDD: <span class="text-danger">(Somente números)</span></label>
                <input type="number" name="telefone" class="form-control" value="{{ old('telefone') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Paróquia:</label>
                <select class="form-control" name="paroquia_id">
                    <option value="">Selecione uma paróquia</option>
                    @foreach ($paroquias as $paroquia)
                        <option value="{{ $paroquia->id }}">{{ $paroquia->name }} - {{ $paroquia->city }} </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-custom btn-lg w-100 mt-3">📩 Enviar Inscrição</button>
        </form>
    </div>

</body>
</html>
