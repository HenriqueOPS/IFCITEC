<?php

use Illuminate\Database\Seeder;
use App\Projeto;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $projeto = new Projeto();
        $projeto->titulo = "Teste de Projeto";
        $projeto->save();
    }
}
