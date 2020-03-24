<?php

namespace App;
use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $guarded = [];

    public function piece(){
        return $this->belongsTo(Piece::class);
    }

    //
}
