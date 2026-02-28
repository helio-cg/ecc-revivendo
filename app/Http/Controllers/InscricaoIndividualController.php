<?php

namespace App\Http\Controllers;

use App\Http\Requests\InscricaoIndividualRequest;
use App\Models\InscricaoIndividual;
use App\Models\Paroquia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use OpenPix\PhpSdk\Client;

class InscricaoIndividualController extends Controller
{
    public function create()
    {
       /* $hoje = Carbon::today();
        $dataLimite = Carbon::createFromFormat('d/m/Y', '27/07/2025'); // por exemplo

        if ($hoje->gt($dataLimite)) {
            return redirect()->route('home');
        }*/

        $paroquias = Paroquia::orderBy('name')->get();
        return view('inscricao-individual.form', compact('paroquias'));
    }

    public function store(InscricaoIndividualRequest $request)
    {
        $inscricao = InscricaoIndividual::create($request->validated());

        $invoiceTotal = 100.00; // valor da inscrição, pode ser dinâmico
        $invoice = $inscricao->invoice()->create([
            'valor' => $invoiceTotal,
            'status' => 'pendente',
        ]);

        $dadosCobrancaCliente = [
            'correlationID' => Uuid::uuid7()->toString(),
            'value' => $invoiceTotal * 100,
            'additionalInfo' => [
                [
                    'key' => 'Número da Fatura',
                    'value' => '#'.$invoice->id
                ]
            ],
        ];

        $openPix = app(Client::class);
        $resposta = $openPix->charges()->create($dadosCobrancaCliente);

        $invoice->update([
            'transactionID' => $resposta['charge']['transactionID'],
            'invoiceUrl' => $resposta['charge']['paymentLinkUrl']
        ]);

        return redirect()->route('inscricao-individual.status', ['telefone' => $inscricao->telefone])->with('success', 'Inscrição realizada com sucesso!');
    }
/*
    public function status($telefone)
    {
        $inscricao = InscricaoIndividual::where('telefone', $telefone)->firstOrFail();
        return view('inscricao-individual.status', compact('inscricao'));
    }*/
}
