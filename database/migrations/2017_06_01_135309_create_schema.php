<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSchema extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $query = DB::statement('CREATE SCHEMA ' . env('DB_SCHEMA'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
