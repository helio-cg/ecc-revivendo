<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InscricaoIndividualRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'nome_usual' => 'required|string|max:255',
            'tamanho_camisa' => 'required|string|max:255',
            'telefone' => [
                'required',
                'string',
                'digits:11', // Garante exatamente 11 números
                'unique:inscricoes,telefone',
            ],
            'paroquia_id' => 'required|integer'
        ];
    }
}
