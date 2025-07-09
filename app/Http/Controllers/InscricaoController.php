<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Paroquia;
use App\Models\Inscricao;
use Illuminate\Http\Request;
use App\Http\Requests\CasalRequest;
use App\Models\InscricaoIndividual;

class InscricaoController extends Controller
{
    public function create()
    {
        $hoje = Carbon::today();
        $dataLimite = Carbon::createFromFormat('d/m/Y', '23/07/2025'); // por exemplo

        if ($hoje->gt($dataLimite)) {
            return redirect()->route('home');
        }
        
        $paroquias = Paroquia::orderBy('name')->get();
        return view('inscricao.form', compact('paroquias'));
    }

    public function store(CasalRequest $request)
    {
        $inscricao = Inscricao::create($request->validated());

        return redirect()->route('inscricao.status', ['telefone' => $inscricao->telefone])->with('success', 'Inscrição realizada com sucesso!');
    }

    public function consultar()
    {
        return view('inscricao.consultar');
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'telefone' => 'required|integer',
            'tipo' => 'required'
        ]);

        if($request->tipo == 'casal'){
            $inscricao = Inscricao::where('telefone', $request->telefone)->first();
        }else{
            $inscricao = InscricaoIndividual::where('telefone', $request->telefone)->first();
        }

        if (!$inscricao) {
            return redirect()->back()->with('error', 'Inscrição não encontrada.');
        }

        if($request->tipo == 'casal'){
            return view('inscricao.status', compact('inscricao'));
        }

        return view('inscricao-individual.status', compact('inscricao'));
    }

    public function status($telefone)
    {
        $inscricao = Inscricao::where('telefone', $telefone)->firstOrFail();
        return view('inscricao.status', compact('inscricao'));
    }
}
