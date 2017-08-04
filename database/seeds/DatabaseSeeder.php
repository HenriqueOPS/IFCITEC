<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(EscolaTableSeeder::class);
        $this->call(NivelTableSeeder::class);
        $this->call(AreaConhecimentoTableSeeder::class);
        $this->call(FuncaoTableSeeder::class);
        //Inserções Manualmente - Temporário, deverá ser retirada quando
        //a feature de link na página de organização estiver feita
        for ($nivel = 1; $nivel < 2; $nivel++) {
            for ($area = 1; $area < 3; $area++) {
                DB::table(env('DB_SCHEMA') . '.area_nivel')->insert(
                        ['area_id' => $area, 'nivel_id' => $nivel]
                );
            }
        }
        
        for ($nivel = 2; $nivel < 5; $nivel++) {
            for ($area = 3; $area < 9; $area++) {
                DB::table(env('DB_SCHEMA') . '.area_nivel')->insert(
                        ['area_id' => $area, 'nivel_id' => $nivel]
                );
            }
        }
        
    }

}
