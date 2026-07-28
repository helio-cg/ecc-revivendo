<?php

namespace App\Http\Middleware;

use App\Models\Settings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BloquearInscricoesAposPrazo
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Settings::inscricoesAbertas()) {
            return redirect()->route('consultar.inscricao.form')
                ->with('error', 'As inscricoes estao encerradas. Apenas a consulta de inscricao esta disponivel.');
        }

        return $next($request);
    }
}
