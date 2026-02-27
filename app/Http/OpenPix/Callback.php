<?php

namespace App\Http\OpenPix;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Callback
{
    // Cobrança criada
    public function chargeCreated(Request $request)
    {
       /* Log::info('OpenPix Callback', [
            'event' => $request->input('event'),
            'data' => $request->all(),
        ]);*/

        return $request;
    }

    // Pagamento concluído
    public function chargeCompleted(Request $request)
    {
        $tarnsationId = $request->input('charge.transactionID');
        $transaction = Invoice::where('transactionID',$tarnsationId)->first();
        if ($transaction) {
            $transaction->update([
                'status' => $request->input('charge.status'),
                'paymentDate' => date('Y-m-d'),
            ]);
        }else {
            return Log::error("Transação openpix não encontrado para a transação ID: $tarnsationId");
        }

        return $request;
    }
}