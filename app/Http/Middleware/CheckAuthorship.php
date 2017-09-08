<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuthorship {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $param = $request->route('projeto');
        if (in_array($param, array_pluck($request->user()->projetos->toArray(), 'id'))
            || Auth::user()->temFuncao('Organizador') || Auth::user()->temFuncao('Avaliador')) {
                return $next($request);
        }
        return redirect('home');
    }

}
