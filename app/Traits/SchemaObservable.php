<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait SchemaObservable
{
    public static function bootSchemaObservable()
    {
        static::saving(function (Model $model) {
            if (isset($model->schema)  ){ //Se model possui atributo Schema
                DB::statement("SET search_path = ".$model->schema);
            }else{ //Se model não possui Schema
                DB::statement("SET search_path = ".env('DB_SCHEMA'));
            }
        });
    }
}