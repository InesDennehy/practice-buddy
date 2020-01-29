<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Piece;
use App\Category;

class PiecesController extends Controller
{
    public function index($id){
        $category = Category::findOrFail($id);
        if($category->user_id == Auth::user()->id){
            $pieces = Piece::where('category_id', $id)->get();
            return response()->json(['pieces' => $pieces]);
        }
        return;
    }

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
