<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaEdicaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('INSERT INTO area_edicao(area_id, edicao_id) VALUES (1, 6)');
    }
}
