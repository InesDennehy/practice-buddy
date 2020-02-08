<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $guarded = [];

    public function piece(){
        return $this->belongsTo(Piece::class);
    }
    //
}
