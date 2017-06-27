<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EscolaTableSeeder::class);
        $this->call(NivelTableSeeder::class);
        $this->call(AreaConhecimentoTableSeeder::class);
    }
}
