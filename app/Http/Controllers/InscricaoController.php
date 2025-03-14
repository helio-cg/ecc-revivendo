<?php

namespace App\Http\Controllers;

use App\Models\Paroquia;
use App\Models\Inscricao;
use Illuminate\Http\Request;
use App\Http\Requests\CasalRequest;

class InscricaoController extends Controller
{
    public function create()
    {
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
            'telefone' => 'required|integer'
        ]);

        $inscricao = Inscricao::where('telefone', $request->telefone)->first();

        if (!$inscricao) {
            return redirect()->back()->with('error', 'Inscrição não encontrada.');
        }

        return view('inscricao.status', compact('inscricao'));
    }

    public function status($telefone)
    {
        $inscricao = Inscricao::where('telefone', $telefone)->firstOrFail();
        return view('inscricao.status', compact('inscricao'));
    }
}
