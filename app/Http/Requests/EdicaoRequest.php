<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Edicao;

class EdicaoRequest extends FormRequest
{

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'inscricao_abertura' => 'required',
			'inscricao_fechamento' => 'required',
			'homologacao_abertura' => 'required',
			'homologacao_fechamento' => 'required',
			'avaliacao_abertura' => 'required',
			'avaliacao_fechamento' => 'required',
			'credenciamento_abertura' => 'required',
			'credenciamento_fechamento' => 'required',
			'voluntario_abertura' => 'required',
			'voluntario_fechamento' => 'required',
			'comissao_abertura' => 'required',
			'comissao_fechamento' => 'required',
			'feira_abertura' => 'required',
			'feira_fechamento' => 'required',
			'projetos' => 'required',

		];
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'inscricao_abertura.required' => 'Esse campo é obrigatório',
			'inscricao_fechamento.required' => 'Esse campo é obrigatório',
			'inscricao_fechamento.after_or_equal' => 'A data do fechamento deve ser posterior a data da abertura',
			'homologacao_abertura.required' => 'Esse campo é obrigatório',
			'homologacao_fechamento.required' => 'Esse campo é obrigatório',
			'homologacao_fechamento.after_or_equal' => 'A data do fechamento deve ser posterior a data da abertura',
			'avaliacao_abertura.required' => 'Esse campo é obrigatório',
			'avaliacao_fechamento.required' => 'Esse campo é obrigatório',
			'avaliacao_fechamento.after_or_equal' => 'A data do fechamento deve ser posterior a data da abertura',
			'credenciamento_abertura.required' => 'Esse campo é obrigatório',
			'credenciamento_fechamento.required' => 'Esse campo é obrigatório',
			'credenciamento_fechamento.after_or_equal' => 'A data do fechamento deve ser posterior a data da abertura',
			'voluntario_abertura.required' => 'Esse campo é obrigatório',
			'voluntario_fechamento.required' => 'Esse campo é obrigatório',
			'voluntario_fechamento.after_or_equal' => 'A data do fechamento deve ser posterior a data da abertura',
			'comissao_abertura.required' => 'Esse campo é obrigatório',
			'comissao_fechamento.required' => 'Esse campo é obrigatório',
			'comissao_fechamento.after_or_equal' => 'A data do fechamento deve ser posterior a data da abertura',
			'feira_abertura.required' => 'Esse campo é obrigatório',
			'feira_fechamento.required' => 'Esse campo é obrigatório',
			'feira_fechamento.after_or_equal' => 'A data do fechamento deve ser posterior a data da abertura',
			'projetos.required' => 'Esse campo é obrigatório',
		];
	}

	/**
	 * Configure the validator instance.
	 *
	 * @param  \Illuminate\Validation\Validator $validator
	 * @return void
	 */
	public function withValidator($validator)
	{
		$validator->addRules(['inscricao_fechamento' => ('date|after_or_equal: ' . $validator->getData()['inscricao_abertura'])]);
		$validator->addRules(['homologacao_fechamento' => ('date|after_or_equal: ' . $validator->getData()['homologacao_abertura'])]);
		$validator->addRules(['avaliacao_fechamento' => ('date|after_or_equal: ' . $validator->getData()['avaliacao_abertura'])]);
		$validator->addRules(['credenciamento_fechamento' => ('date|after_or_equal: ' . $validator->getData()['credenciamento_abertura'])]);
		$validator->addRules(['voluntario_fechamento' => ('date|after_or_equal: ' . $validator->getData()['voluntario_abertura'])]);
		$validator->addRules(['comissao_fechamento' => ('date|after_or_equal: ' . $validator->getData()['comissao_abertura'])]);
		$validator->addRules(['feira_fechamento' => ('date|after_or_equal: ' . $validator->getData()['feira_abertura'])]);

        // XGH
        // valida os níveis e áreas por Callback
        // ME PERDOE POR ISSO =(
		$validator->after(function ($validator) {
			if (empty($validator->getData()['nivel_id'])) {
				$validator->errors()->add('nivel_id[]', 'É necessário informar pelo menos 1 nível');
			}
			if (empty($validator->getData()['area_id'])) {
				$validator->errors()->add('area_id[]', 'É necessário informar pelo menos 1 área do conhecimento');
			}
		});

	}

}
