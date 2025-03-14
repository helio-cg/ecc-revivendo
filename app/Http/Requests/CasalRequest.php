<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CasalRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'nome_ele' => 'required|string|max:255',
            'nome_ela' => 'required|string|max:255',
            'nome_usual_ele' => 'required|string|max:255',
            'nome_usual_ela' => 'required|string|max:255',
            'telefone' => [
                'required',
                'string',
                'digits:11', // Garante exatamente 11 números
                'unique:inscricoes,telefone',
            ],
            'paroquia_id' => 'required|integer'
        ];
    }

    public function messages(): array {
        return [
            'nome_ele.required' => 'O nome completo dele é obrigatório.',
            'nome_ela.required' => 'O nome completo dela é obrigatório.',
            'nome_usual_ele.required' => 'O nome usual dele é obrigatório.',
            'nome_usual_ela.required' => 'O nome usual dela é obrigatório.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.unique' => 'Este telefone já está cadastrado.',
            'telefone.digits' => 'O telefone com o DDD deve conter exatamente 11 dígitos numéricos.',
            'paroquia_id' => 'Selecione sua paróquia.',
        ];
    }
}
