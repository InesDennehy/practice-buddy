<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Piece;
use App\Category;
use App\Session;
use Illuminate\Support\Carbon;
use SebastianBergmann\Environment\Console;

class PiecesController extends Controller
{

    public function store(){
        request()->validate([
            'piece_name' => 'required',
            'category' => 'required',
        ]);
        $category = Category::where([['name', request('category')], ['user_id', Auth::user()->id]])->get()->first();
        if($category != null){
            $piece = Piece::create([
                'category_id' => $category->id,
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
