<?php

namespace App\Providers;

use App\Mensagem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!app()->runningInConsole() || app()->runningUnitTests()) {
            $this->app['view']->composer('auth.login', function ($view) {
                $teladelogin = DB::table('media')->where('nome', '=', 'teladelogin')->value('conteudo');
                $view->with('teladelogin', $teladelogin);
                $logo = DB::table('media')->where('nome', '=', 'logonormal')->value('conteudo');
                $view->with('logo', $logo);
            });
        }

        if (!app()->runningInConsole() || app()->runningUnitTests()) {
            // Set global variables
            $background = DB::table('media')->where('nome', '=', 'background')->value('conteudo');
            view()->share('background', $background);

            $logonormal = DB::table('media')->where('nome', '=', 'logonormal')->value('conteudo');
            view()->share('logonormal', $logonormal);

            $cor = DB::table('mensagem')->where('nome', '=', 'cor_navbar')->value('conteudo');
            view()->share('cor', $cor);

            $coravisos = Mensagem::where('nome', '=', 'cor_avisos')->first();
            if ($coravisos) {
                view()->share('coravisos', $coravisos->conteudo);
            }

            $mensagem = Mensagem::where('nome', '=', 'Aviso(CadastroDeParticipante)')->first();
            if ($mensagem) {
                view()->share('aviso1', $mensagem->conteudo);
            }

            $corbotoes = Mensagem::where('nome', '=', 'cor_botoes')->first();
            if (!$corbotoes) {
                // Create a new record if 'cor_botoes' doesn't exist
                $corbotoes = new Mensagem();
                $corbotoes->nome = 'cor_botoes';
                $corbotoes->tipo = 'cor';
                $corbotoes->conteudo = '#000';
                $corbotoes->save();
            }
            view()->share('corbotoes', $corbotoes->conteudo);
        }

        Schema::defaultStringLength(191);

        if (env('APP_ENV') !== 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
