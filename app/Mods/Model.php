<?php

namespace App\Mods;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {

    public function getTable() {
        $schema = isset($this->schema) ? $this->schema : env('DB_SCHEMA');
        return $schema . '.' . $this->table;
    }

}
