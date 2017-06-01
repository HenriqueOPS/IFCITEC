<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /*
        //dd(config('database.connections.pgsql.schema'));
        $query = DB::statement('CREATE SCHEMA ' . env('DB_SCHEMA'));
        //dd($query);
        config(['database.connections.pgsql.schema' => env('DB_SCHEMA')]);
        DB::statement("SET search_path = ".env('DB_SCHEMA'));
        */
        
        $query = DB::statement('CREATE SCHEMA ' . env('DB_SCHEMA'));
        config(['database.connections.pgsql.prefix' => env('DB_SCHEMA').'.']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
