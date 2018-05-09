<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Nivel;

class ProjetoRequest extends FormRequest {

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
            'titulo' => 'required',
            'resumo' => 'required',
            'palavras_chaves' => 'required',
            'nivel' => 'required',
            'area_conhecimento' => 'required',
            'funcao' => 'required',
            'escola' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'titulo.required' => 'O título é obrigatório',
            'resumo.required' => 'O resumo é obrigatório',
            'resumo.between' => 'O resumo deve conter de :min a :max caracteres',
            'nivel.required' => 'É necessário definir um nível',
            'area_conhecimento.required' => 'É necessário definir uma área do conhecimento',
            'funcao.required' => 'É necessário definir a sua função neste projeto',
            'escola.required' => 'É necessário informar a escola pela qual você está vínculado neste projeto'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator) {
     //   $validator->getData()['nivel'];
     //   $validator->addRules(['resumo' => 'required|between: min_ch,max_ch']);


      
        //$validator->addRules(['resumo' => 'required|between: 1000,1500']);

                $dados = Nivel::find($validator->getData()['nivel']);
               // dd($dados->min_ch);
                $validator->addRules(['resumo' => ('required|between: '.$dados->min_ch.','.$dados->max_ch)]);
                               

        $validator->after(function ($validator) {
            $totalPalavras = (count(explode(",", $validator->getData()['palavras_chaves'])));
            switch ($validator->getData()['nivel']) {
                case 1:
                    if ($totalPalavras < 2) {
                        $validator->errors()->add('palavras_chaves', 'É necessário ao menos duas palavras-chaves');
                    }
                    break;
                default:
                    if ($totalPalavras < 3) {
                        $validator->errors()->add('palavras_chaves', 'É necessário ao menos três palavras-chaves');
                    }
            }
        });
    }

}
