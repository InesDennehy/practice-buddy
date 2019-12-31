<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PieceCategory extends Model
{
    protected $guarded = [];
    //
    public function pieces(){
        return $this->hasMany(Piece::class);
    }
}
