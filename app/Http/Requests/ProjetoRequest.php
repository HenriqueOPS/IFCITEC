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

    	// Valida o numero de caracteres do resumo de acordo com o nível
		$dadosNivel = Nivel::find($validator->getData()['nivel']);
		$validator->addRules(['resumo' => ('required|between: ' . $dadosNivel->min_ch . ',' . $dadosNivel->max_ch)]);

		$autores = $validator->getData()['autor'];
		$cont = 0;
		foreach ($autores as $autor) {
			if($autor != null)
				$cont++;
		}

		if ($cont == 0) {
			$validator->sometimes('autor[]', 'required', function($input) use ($cont){
				return $input->$cont == 0;
			});

			$validator->errors()->add('autor[]', 'É necessário ao menos um autor');
		}

		// Faz algumas validações como "callback"
		$validator->after(function ($validator) {
			// conta as palavras-chaves
			$countPalavrasChaves = explode(",", $validator->getData()['palavras_chaves']);
			$countPalavrasChaves = count($countPalavrasChaves);
			$numPalavras = Nivel::find($validator->getData()['nivel'])->palavras;

			// Valida o número de palavras-chaves de acordo com o requerido pelo nível
			if ($countPalavrasChaves < $numPalavras)
				$validator->errors()->add('palavras_chaves', 'As palavras-chave devem conter pelo menos ' . $numPalavras . ' palavras');

			// Valida se os corientadores já fazem parte da comissão avaliadora na mesma área
			$coorientadores = $validator->getData()['coorientador'];
			foreach ($coorientadores as $coorientador) {
				if ($coorientador != null) {
					if (Pessoa::find($coorientador)->comissaoArea($validator->getData()['area_conhecimento'], $coorientador) == false)
						$validator->errors()->add('coorientador[]', 'Não é possível adicionar esse coorientador');
				}
			}

			// Valida se o orientador já faz parte da comissão avaliadora na mesma área
			$orientador = $validator->getData()['orientador'];
			if (Pessoa::find($orientador)->comissaoArea($validator->getData()['area_conhecimento'], $orientador) == false)
				$validator->errors()->add('orientador', 'Não é possível adicionar esse orientador');

			// Valida se não tem integrantes repetidos
			$autores = $validator->getData()['autor'];
			foreach ($autores as $autor) {

				if (isset($autor) && $autor == $orientador) {
					$validator->errors()->add('autor[]', 'Não é possível informar dois participantes iguais');
					$validator->errors()->add('orientador', 'Não é possível informar dois participantes iguais');
				}

				foreach ($coorientadores as $coorientador) {
					if (isset($autor) && $autor == $coorientador) {
						$validator->errors()->add('autor[]', 'Não é possível informar dois participantes iguais');
						$validator->errors()->add('coorientador[]', 'Não é possível informar dois participantes iguais');
					}

					if (isset($orientador) && $orientador == $coorientador) {
						$validator->errors()->add('coorientador[]', 'Não é possível informar dois participantes iguais');
						$validator->errors()->add('orientador', 'Não é possível informar dois participantes iguais');
					}
				}
			}
		});
    }

}
