<?php

namespace App\Http\Controllers;

use App\Models\Inscricao;
use Illuminate\Http\Request;

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

    if (!$inscricao) {
        $inscricao = \App\Models\InscricaoIndividual::with(['invoice','paroquia'])
            ->where('telefone', $telefone)
            ->first();
    }

    if (!$inscricao) {
        return redirect()->back()->with('error', 'Inscrição não encontrada.');
    }
     $tipo = $inscricao instanceof Inscricao ? 'casal' : 'individual';

    return view('resultado-inscricao', compact('inscricao', 'tipo'));
}



}
