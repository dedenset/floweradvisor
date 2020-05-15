<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Troli extends Model
{
    public function troli_detail(){
        return $this->hasMany('App\TroliDetail', 'troli_id', 'id');
    }
}
