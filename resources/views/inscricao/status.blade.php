<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status da Inscrição</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e3f2fd);
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 900px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .status-badge {
            font-size: 1.1rem;
            padding: 8px 15px;
            border-radius: 8px;
        }
        .btn-whatsapp {
            background-color: #25D366;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-whatsapp:hover {
            background-color: #1EBE5D;
            transform: scale(1.05);
        }
        .btn-payment {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            font-weight: bold;
            padding: 12px;
            border-radius: 8px;
            display: block;
            text-decoration: none;
            transition: 0.3s ease-in-out;
        }
        .btn-payment:hover {
            background: linear-gradient(135deg, #218838, #28a745);
            transform: scale(1.05);
        }
        .btn-back {
            color: #dc3545;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-back:hover {
            color: #a71d2a;
            transform: scale(1.05);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">🎉 Status da Inscrição</h2>
        </div>

        <div class="card  border-0 mb-3">
            <div class="card-body text-center">
                <h3 class="fw-bold text-secondary">{{ $inscricao->nome_usual_ele }} & {{ $inscricao->nome_usual_ela }}</h3>
                <hr class="my-3">

                <p><strong class="text-primary">📍 Paróquia:</strong> {{ $inscricao->paroquia->name }} - {{ $inscricao->paroquia->city }}</p>
                <p><strong class="text-primary">👤 Nome completo:</strong><br> {{ $inscricao->nome_ele }} <br> {{ $inscricao->nome_ela }}</p>
                <p><strong class="text-primary">📞 Telefone:</strong> {{ '(' . substr($inscricao->telefone, 0, 2) . ') ' . substr($inscricao->telefone, 2, 5) . '-' . substr($inscricao->telefone, 7) }}</p>

                <p><strong class="text-primary">💰 Status de Pagamento:</strong>
                    <span class="status-badge badge bg-{{ $inscricao->status_pagamento == 'pago' ? 'success' : 'warning' }}">
                        {{ ucfirst($inscricao->status_pagamento) }}
                    </span>
                </p>

                @if ($inscricao->status_pagamento == 'pendente')
                    <p>
                        <a href="https://wa.me/5588982121807" target="_blank" class="btn-whatsapp shadow-lg">
                            <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="25">
                            Enviar Comprovante para WhatsApp (88) 98212-1807
                        </a>
                    </p>
                @endif
            </div>
        </div>

        @if ($inscricao->status_pagamento == 'pendente')
            <div class="card shadow-lg border-0 p-4 bg-white text-center">
                <h2 class="fw-bold text-danger">💳 Fazer Pagamento</h2>
                <h5 class="text-secondary">Recebedor: <br><span class="fw-bold">ARTRS SERVIÇOS - R DE SOUZA SERVIÇOS LTDA</span></h5>

                <div class="mt-4">
                    <a class="btn-payment shadow-sm" href="https://api-gateway.c6bank.info/v1/payment/3f708898-94fd-457e-903c-8188a9cf50cc" target="_blank">
                        🏦 Pagar com Cartão de Crédito/Débito
                    </a>
                </div>

                <hr class="my-4">

                <h5 class="text-primary">📌 Pagar com QR Code Pix</h5>
                <img src="/img/qrcode-pix.jpeg" class="img-fluid rounded shadow-lg w-50 d-block mx-auto" alt="QR Code Pix">

                <h5 class="mt-3 text-primary">🔗 Chave Pix - Copia e Cola</h5>
                <div class="alert alert-warning fw-bold">
                    00020101021126580014br.gov.bcb.pix0136dbbbbf12-8086-4567-bcdc-5f43ed158f8a520400005303986540590.005802BR5914ARTRS SERVICOS6009SAO PAULO622905251JPA96XKMYDSVGYXDP5HA7XSH6304ED1D
                </div>

                <a href="{{ route('inscricao.consultar') }}" class="btn-back mt-3">
                    ⬅ Voltar
                </a>
            </div>
        @endif
    </div>

</body>
</html>
