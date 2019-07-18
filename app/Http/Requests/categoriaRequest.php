<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\categoria;

class categoriaRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'edicao_id'=>'required',
            'nivel_id'=>'required',
            'categoria_avaliacao' => 'required',
            'peso' => 'required',
            'descricao' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'categoria_avaliacao.required' => 'O nome da categoria é obrigatório',
            'peso.required' => 'O peso da categoria é obrigatório',
            'descricao.required' => 'A descrição da categoria é obrigatório',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator) {

    }

}