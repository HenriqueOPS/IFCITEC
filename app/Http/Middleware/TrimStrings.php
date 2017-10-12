<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as BaseTrimmer;

class TrimStrings extends BaseTrimmer
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
        '_token',
    ];
    
    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value) {
        if (in_array($key, $this->except, true)) {
            return $value;
        }
        
        return is_string($value) ? $this->sanitize($value): $value;
    }
    
    /**
     * Transforms multiple spaces into 1, performs TRIM,
     * and uses the SANITIZE_STRING filter
     *
     * @param  mixed  $value
     * @return mixed
     */
    //RIP Classe Igreja T: 17/07/2016 *: 04/07/17
    protected function sanitize($value){
        $value = trim(preg_replace('!\s+!', ' ', $value));
        $value = trim($value);
        $value = filter_var($value, FILTER_SANITIZE_STRING);
        return $value;
    }
}
