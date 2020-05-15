<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TroliDetail extends Model
{
    public function troli(){
        return $this->belongsTo('App\Troli', 'troli_id', 'id');
    }
}
