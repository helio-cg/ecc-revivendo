<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'nome_usual' => 'required|string|max:255',
            'tamanho_camisa' => 'required|string|max:255',
            'telefone' => [
                'required',
                'digits_between:10,11', // Brasil fixo ou celular
                'unique:inscricoes,telefone',
            ],
            'paroquia_id' => 'required|integer'
        ];


    }
    protected function prepareForValidation()
    {
        if ($this->telefone) {
            $this->merge([
                'telefone' => preg_replace('/\D/', '', $this->telefone),
            ]);
        }
    }
}
