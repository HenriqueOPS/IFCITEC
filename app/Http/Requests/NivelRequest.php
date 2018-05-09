<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Nivel;

class NivelRequest extends FormRequest {

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
            'nivel' => 'required',
            'min_ch' => 'required',
            'max_ch' => 'required',
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
            'nivel.required' => 'O nome do nível é obrigatório',
            'min_ch.required' => 'O campo caracteres mínimos é obrigatório',
            'max_ch.min' => 'Os caracteres máximos devem conter pelo menos :min caracteres',
            'max_ch.required' => 'O campo caracteres máximos é obrigatório',
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

                //$dados =$validator->getData()['nivel']);
               // dd($dados->min_ch);
                $validator->addRules(['max_ch' => ('required|min: '.$validator->getData()['min_ch'])]);
    }

}