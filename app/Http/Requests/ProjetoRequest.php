<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Nivel;
use App\Pessoa;
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

		// XGH
		// valida as palavras chaves por Callback
		// ME PERDOE POR ISSO =(
		$validator->after(function ($validator) {
			$totalPalavras = (count(explode(",", $validator->getData()['palavras_chaves'])));

			$numPalavras = Nivel::find($validator->getData()['nivel']);

			if($totalPalavras < $numPalavras->palavras) {
				$validator->errors()->add('palavras_chaves', 'As palavras-chave devem conter pelo menos '.$numPalavras->palavras.' palavras');
			}

			$autor = $validator->getData()['autor'];
			$orientador = $validator->getData()['orientador'];
			$coorientador = $validator->getData()['coorientador'];

            foreach ($coorientador as $c) {
                if($c != null){
                if(Pessoa::find($c)->comissaoNivel($validator->getData()['nivel'], $c) == false){
                    $validator->errors()->add('coorientador[]', 'Não é possível adicionar esse coorientador');
                }
                }
            }

            if(Pessoa::find($orientador)->comissaoNivel($validator->getData()['nivel'], $orientador) == false){
                    $validator->errors()->add('orientador', 'Não é possível adicionar esse orientador');
            }

			foreach ($autor as $a) {
				foreach ($coorientador as $c) {
					if((isset($a) && $a == $orientador) ||
					   (isset($a) && $a == $c) ||
					   (isset($orientador) && $orientador == $c)){
						$validator->errors()->add('autor[]', 'Não é possível informar dois participantes iguais');
						$validator->errors()->add('orientador', 'Não é possível informar dois participantes iguais');
						$validator->errors()->add('coorientador[]', 'Não é possível informar dois participantes iguais');
					}
				}
			}

		});
    }

}
