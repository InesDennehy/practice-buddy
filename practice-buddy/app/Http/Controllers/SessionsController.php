<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Carbon;
use App\Piece;
use App\Session;

class SessionsController extends Controller{

    public function store(){
        request()->validate([
            'piece' => 'required',
        ]);
        $piece = Piece::findOrFail(request('piece'));
        if($piece->category->user_id == Auth::user()->id){
            $session = Session::create([
                'piece_id' => $piece->id,
            ]);
            return response()->json(['result' => 'OK', 'session' => $session->id]);
        }
        return response()->json(['result' => 'error']);
    }

    public function delete($id){
        $session = Session::findOrFail($id);
        if($session->piece->category->user_id == Auth::user()->id){
            $session->delete();
            return response()->json(['result' => 'OK']);
        }
        return response()->json(['result' => 'error']);
    }
    //
}
