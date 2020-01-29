<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    protected $guarded = [];
    //
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function objetctives(){
        return $this->hasMany(Objective::class);
    }

    public function sessions(){
        return $this->hasMany(PracticeSession::class);
    }
}
