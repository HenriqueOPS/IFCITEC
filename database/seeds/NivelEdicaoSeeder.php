<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelEdicaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('INSERT INTO nivel_edicao(nivel_id, edicao_id) VALUES (1, 6)');
    }
}
