<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PieceCategory extends Model
{
    //
    public function pieces(){
        return $this->hasMany(Piece::class);
    }
}
