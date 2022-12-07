<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Nivel;
use App\Pessoa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginRequest extends FormRequest
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

        Validator::extend('campoExiste', function ($field, $valor, $parameters) {
            if ($field == 'email') {
                return Pessoa::where('email', '=', $valor)->first() != null;
            } else if ($field == 'password') {
                if (Pessoa::where('email', '=', $this->email)->first() == null)
                    return false;

                return Hash::check($valor, Pessoa::where('email', '=', $this->email)->first()->senha);
            }
        });

        return [
            'email' => 'required|campoExiste',
            'password' => 'required|campoExiste',
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
            'email.required' => 'O campo de email é obrigatorio',
            'password.required' => 'O campo de senha é obrigatorio',
            'campo_existe' => 'Credenciais Invalidas',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
    }
}
