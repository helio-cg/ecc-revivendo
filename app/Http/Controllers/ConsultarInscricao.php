<?php

namespace App\Http\Controllers;

use App\Models\Inscricao;
use App\Models\Paroquia;
use OpenPix\PhpSdk\Client;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ConsultarInscricao extends Controller
{
    public function consultar(Request $request)
    {
        $telefone =  $request->telefone;
        $inscricao = Inscricao::where('telefone', $telefone)->with(['invoice','paroquia'])->first();

        if (!$inscricao) {
            $inscricao = \App\Models\InscricaoIndividual::where('telefone', $telefone)->with(['invoice','paroquia'])->first();
        }

        if (!$inscricao) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma inscrição encontrada'
            ]);
        }


        $response = $inscricao;
        $response['tipo'] = $inscricao instanceof Inscricao ? 'casal' : 'individual';

        return view('consultar-inscricao', ['response' => $response]);

    }


    public function mostrar($telefone)
    {
        $telefone = preg_replace('/\D/', '', $telefone);

        $inscricao = \App\Models\Inscricao::with(['invoice','paroquia'])
            ->where('telefone', $telefone)
            ->first();
        
        if(is_null($inscricao)) {
            return redirect()->back()->with('error', 'Inscrição não encontrada.');
        }

        if (!$inscricao) {
            $inscricao = \App\Models\InscricaoIndividual::with(['invoice','paroquia'])
                ->where('telefone', $telefone)
                ->first();
        }
        //dd($inscricao);
        $openPix = app(Client::class);
        $charge = $openPix->charges()->getOne($inscricao->invoice->transactionID);
        if (!$charge) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma cobrança encontrada para esta inscrição'
            ]);
        }

        if ($charge['charge']['status'] === 'EXPIRED') {
            $paroquia = Paroquia::where('id',$inscricao['paroquia_id'])->first();
            $nome = $inscricao['nome_usual_ele'] . ' e ' . $inscricao['nome_usual_ela'];
            $paroquias = $paroquia->name . ' de ' . $paroquia->city;
            
                $dadosCobrancaCliente = [
                    'correlationID' => Uuid::uuid7()->toString(),
                    'value' => $inscricao->invoice->valor * 100,
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

            $inscricao->invoice->update([
                'transactionID' => $resposta['charge']['transactionID'],
                'invoiceUrl' => $resposta['charge']['paymentLinkUrl']
            ]);
        }  

        if (!$inscricao) {
            return redirect()->back()->with('error', 'Inscrição não encontrada.');
        }
        
        $tipo = $inscricao instanceof Inscricao ? 'casal' : 'individual';

        return view('resultado-inscricao', compact('inscricao', 'tipo'));
    }

}
