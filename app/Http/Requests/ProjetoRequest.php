<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Nivel;
use App\Projeto;

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
            'escola' => 'required',
            'orientador' => 'required',
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
            'escola.required' => 'É necessário informar a escola pela qual você está vínculado neste projeto',
            'orientador.required' => 'É necessário informar o orientador deste projeto',
            'palavras_chaves.required' => 'É necessário informar palavras-chave',
            'palavras_chaves.min' => 'As palavras-chave devem conter pelo menos :min palavras',

        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator) {   

            $dados = Nivel::find($validator->getData()['nivel']);
            $validator->addRules(['resumo' => ('required|between: '.$dados->min_ch.','.$dados->max_ch)]);
            $autor = $validator->getData()['autor'];
            $cont = 0;
            foreach ($autor as $a) {
                if($a != null){
                    $cont++;
                }
            }       
            if($cont == 0){
                $validator->sometimes('autor[]', 'required', function($input) use ($cont){
                return $input->$cont == 0;
                });
                $validator->errors()->add('autor[]', 'É necessário ao menos um autor');
            }
           
            $totalPalavras = (count(explode(",", $validator->getData()['palavras_chaves'])));
            if($totalPalavras < $dados->palavras) {
                $validator->addRules(['palavras_chaves' => ('required|min: '. $dados->palavras)]);
                
            }

    }

}
