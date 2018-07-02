<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\AreaConhecimento;

class AreaRequest extends FormRequest {

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
            'area_conhecimento' => 'required',
            'nivel_id' => 'required',
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
            'area_conhecimento.required' => 'O nome da área do area_conhecimento é obrigatório',
            'nivel_id.required' => 'O nível da área do conhecimento é obrigatório',
            'descricao.required' => 'A descrição do nível é obrigatório',
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