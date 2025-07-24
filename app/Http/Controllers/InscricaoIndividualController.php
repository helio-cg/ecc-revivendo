<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Paroquia;
use Illuminate\Http\Request;
use App\Models\InscricaoIndividual;
use App\Http\Requests\InscricaoIndividualRequest;

class InscricaoIndividualController extends Controller
{
    public function create()
    {
        $hoje = Carbon::today();
        $dataLimite = Carbon::createFromFormat('d/m/Y', '25/07/2025'); // por exemplo

        if ($hoje->gt($dataLimite)) {
            return redirect()->route('home');
        }

        $paroquias = Paroquia::orderBy('name')->get();
        return view('inscricao-individual.form', compact('paroquias'));
    }

    public function store(InscricaoIndividualRequest $request)
    {
        $inscricao = InscricaoIndividual::create($request->validated());

        return redirect()->route('inscricao-individual.status', ['telefone' => $inscricao->telefone])->with('success', 'Inscrição realizada com sucesso!');
    }

    public function status($telefone)
    {
        $inscricao = InscricaoIndividual::where('telefone', $telefone)->firstOrFail();
        return view('inscricao-individual.status', compact('inscricao'));
    }
}
