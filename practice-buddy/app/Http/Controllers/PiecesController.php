<?php

namespace App\Http\Controllers;

use Auth;
use App\Piece;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PiecesController extends Controller
{
    public function all(){
        $pieces = DB::table('pieces')->join('categories', 'pieces.category_id', 'categories.id')
            ->where('categories.user_id', Auth::user()->id)->select('pieces.name as name')->get()->map(
                function($item){return $item->name;}
            );;
        $categories = Category::where('user_id', Auth::user()->id)->select('name')->get()->map(
            function($item){return $item->name;}
        );
        return response()->json(['pieces' => $pieces, 'categories' => $categories]);
    }

    public function index($id){
        $category = Category::findOrFail($id);
        if($category != null && $category->user_id == Auth::user()->id){
            $pieces = $category->pieces()
            ->leftJoin('sessions', function($join) {
                $join->on('sessions.piece_id', '=', 'pieces.id')
                ->whereDate('sessions.created_at','=', Carbon::today());
            })
            ->select('pieces.name as name', 'pieces.id as id', 'sessions.id as session', 'pieces.category_id')
            ->where("pieces.category_id", $category->id)
            ->get();
            return response()->json(['result' => 'OK', 'pieces' => $pieces]);
        }
        return response()->json(['result' => 'unauthorized access or null category']);
    }

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

            return response()->json(['status' => 'OK', 'piece' => $piece]);
        }
        return response()->json(['status' => 'unauthorized access or category non existant']);
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
