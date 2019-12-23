<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    //
    public function objetctives(){
        return $this->hasMany(Objective::class);
    }

    public function sessions(){
        return $this->hasMany(PracticeSession::class);
    }
}
