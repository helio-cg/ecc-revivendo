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
        $paroquia = Paroquia::where('id',$request->paroquia_id)->first();
        $telefone = $request->telefone;
        $dados = $request->validated();

        $nome = $request->nome_usual;
        $paroquias = $paroquia->name . ' de ' . $paroquia->city;

        $inscricao = InscricaoIndividual::create($dados);

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
                    'key' => 'Nome',
                    'value' => $nome
                ],
                [
                    'key' => 'Paróquia',
                    'value' =>  $paroquias
                ]
            ],
        ];

        $openPix = app(Client::class);
        $resposta = $openPix->charges()->create($dadosCobrancaCliente);

        $invoice->update([
            'transactionID' => $resposta['charge']['transactionID'],
            'invoiceUrl' => $resposta['charge']['paymentLinkUrl']
        ]);

        return redirect()->route('consultar-inscricao.form', compact('telefone'))->with('success', 'Inscrição realizada com sucesso!');
    }

}
