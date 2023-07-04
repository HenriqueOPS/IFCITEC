<?php

namespace App\Providers;
use App\Mensagem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Media;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        if (!app()->runningInConsole() || app()->runningUnitTests()) {
            $this->app['view']->composer('auth.login', function ($view) {
                $teladelogin = DB::table('media')->where('nome', '=', 'teladelogin')->value('conteudo');
                $view->with('teladelogin', $teladelogin);
                $logo = DB::table('media')->where('nome', '=', 'logonormal')->value('conteudo');
                $view->with('logo', $logo);
            });
        }

        if (!app()->runningInConsole() || app()->runningUnitTests()) {
            //seta variaveis globais
            $background = DB::table('media')->where('nome', '=', 'background')->value('conteudo');
            view()->share('background', $background);
            $logonormal = DB::table('media')->where('nome', '=', 'logonormal')->value('conteudo');
            view()->share('logonormal', $logonormal);
            $cor = DB::table('mensagem')->where('nome','=','cor_navbar')->get();
            $coravisos = Mensagem::where('nome', '=', 'cor_avisos')->get();
            view()->share('coravisos', $coravisos[0]->conteudo);
            view()->share('cor', $cor[0]->conteudo);
            $mensagem = Mensagem::where('nome', '=', 'Aviso(CadastroDeParticipante)')->get();
            view()->share('aviso1', $mensagem[0]->conteudo);
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
    public function register() {
        //
    }

}
