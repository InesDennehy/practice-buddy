<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Piece;
use App\Category;
use App\Session;
use Illuminate\Support\Carbon;

class PiecesController extends Controller
{

    public function store(){
        request()->validate([
            'piece_name' => 'required',
            'category' => 'required'
        ]);
        if(request('category')['user_id'] == Auth::user()->id){
            $piece = Piece::create([
                'category_id' => request('category')['id'],
                'name' => request('piece_name'),
                'note' => "",
            ]);
            return response()->json(['piece' => $piece]);
        }
        return;
    }

    public function delete($id){
        $piece = Piece::findOrFail($id);
        if($piece->category->user_id == Auth::user()->id){
            $piece->delete();
            return response()->json(['result' => 'ok']);
        }
        return response()->json(['result' => 'error']);
    }
}
