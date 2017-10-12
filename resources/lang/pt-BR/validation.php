<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute deve ser aceito.',
    'active_url'           => ':attribute não é um URL válido.',
    'after'                => ':attribute deve ser uma data após :date.',
    'after_or_equal'       => ':attribute deve ser uma data após ou igual a :date.',
    'alpha'                => ':attribute pode conter apenas letras.',
    'alpha_dash'           => ':attribute pode conter apenas letras, números e traços.',
    'alpha_num'            => ':attribute pode conter apenas letras e números.',
    'array'                => ':attribute deve ser uma matriz.',
    'before'               => ':attribute deve ser uma data anterior a :date.',
    'before_or_equal'      => ':attribute deve ser uma data anterior ou igual a :date.',
    'between'              => [
        'numeric' => ':attribute deve estar entre :min e :max.',
        'file'    => ':attribute deve estar entre :min e :max kilobytes.',
        'string'  => ':attribute deve estar entre :min e :max caracteres.',
        'array'   => ':attribute deve ter entre :min e :max itens.',
    ],
    'boolean'              => ':attribute deve ser verdadeiro ou falso.',
    'confirmed'            => 'A confirmação de :attribute não corresponde.',
    'date'                 => ':attribute não é uma data válida.',
    'date_format'          => ':attribute não corresponde ao formato :format.',
    'different'            => ':attribute e :other devem ser diferentes.',
    'digits'               => ':attribute deve conter :digits dígitos.',
    'digits_between'       => ':attribute deve conter entre :min e :max dígitos.',
    'dimensions'           => ':attribute tem dimensões de imagem inválidas.',
    'distinct'             => ':attribute tem um valor duplicado.',
    'email'                => ':attribute deve ser um endereço de e-mail válido.',
    'exists'               => ':attribute selecionado é inválido.',
    'file'                 => ':attribute deve ser um arquivo.',
    'filled'               => ':attribute deve ter um valor.',
    'image'                => ':attribute deve ser uma imagem.',
    'in'                   => ':attribute selecionado é inválido.',
    'in_array'             => ':attribute não existe em :other.',
    'integer'              => ':attribute deve ser um inteiro.',
    'ip'                   => ':attribute deve ser um endereço IP válido.',
    'ipv4'                 => ':attribute deve ser um endereço IPv4 válido.',
    'ipv6'                 => ':attribute deve ser um endereço IPv6 válido.',
    'json'                 => ':attribute deve ser uma cadeia JSON válida.',
    'max'                  => [
        'numeric' => ':attribute não pode ser maior que :max.',
        'file'    => ':attribute não pode ser maior que :max kilobytes.',
        'string'  => ':attribute não pode ser maior que :max caracteres.',
        'array'   => ':attribute não pode ter mais do que :max itens.',
    ],
    'mimes'                => ':attribute deve ser um arquivo de tipo: :values.',
    'mimetypes'            => ':attribute deve ser um arquivo de tipo: :values.',
    'min'                  => [
        'numeric' => ':attribute deve ser pelo menos :min.',
        'file'    => ':attribute deve ter pelo menos :min kilobytes.',
        'string'  => ':attribute deve ter pelo menos :min caracteres.',
        'array'   => ':attribute deve ter pelo menos :min itens.',
    ],
    'not_in'               => ':attribute selecionado é inválido.',
    'numeric'              => ':attribute deve ser um número.',
    'present'              => ':attribute deve estar presente.',
    'regex'                => 'O formato de :attribute é inválido.',
    'required'             => ':attribute é obrigatório.',
    'required_if'          => ':attribute é necessário quando :other é :value.',
    'required_unless'      => ':attribute é obrigatório a não ser que :other esteja em :values.',
    'required_with'        => ':attribute é necessário quando :values ​​estiverem presentes.',
    'required_with_all'    => ':attribute é necessário quando :values ​​estiverem presentes.',
    'required_without'     => ':attribute é necessário quando :values ​​não estão presentes.',
    'required_without_all' => ':attribute é necessário quando nenhum dos :values estiver presente.',
    'same'                 => ':attribute e :other devem corresponder.',
    'size'                 => [
        'numeric' => ':attribute deve ter :size.',
        'file'    => ':attribute deve ter :size kilobytes.',
        'string'  => ':attribute deve ter :size characters.',
        'array'   => ':attribute deve ter :size items.',
    ],
    'string'               => ':attribute deve ser uma string.',
    'timezone'             => ':attribute deve ser uma zona válida.',
    'unique'               => ':attribute já está sendo utilizado.',
    'uploaded'             => ':attribute falhou ao carregar.',
    'url'                  => 'O formato de :attribute é inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
