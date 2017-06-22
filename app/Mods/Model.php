<?php

namespace App\Mods;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use App\Traits\SchemaObservable as SchemaObservable;

class Model extends EloquentModel {

    use SchemaObservable;

    public function getTable() {
        $schema = isset($this->schema) ? $this->schema : env('DB_SCHEMA');
        return $schema . '.' . $this->table;
    }

}
