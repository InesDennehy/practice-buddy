<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Session;
use Illuminate\Support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index(){
        $data = DB::table('categories')
            ->join('pieces', 'categories.id', '=', 'pieces.category_id')
            ->leftJoin('sessions', function($join) {
                $join->on('sessions.piece_id', '=', 'pieces.id')
                ->whereDate('sessions.created_at','=', Carbon::today());
            })
            ->select('pieces.id as piece_id', 'categories.user_id', 'categories.name as category_name', 'pieces.name as piece_name', 'sessions.id as session_id')
            ->where('categories.user_id', Auth::user()->id)
            ->get();
        return response()->json(['data' => $data]);
    }

    public function store(){
        request()->validate([
            'category_name' => 'required',
        ]);
        $category = Category::create([
            'name' => request('category_name'),
            'user_id' => Auth::user()->id,
        ]);
        return response()->json(['category' => $category]);
    }

    public function delete($id){
        $category = Category::findOrFail($id);
        if($category->user_id == Auth::user()->id){
            foreach($category->pieces as $piece){
                $piece->delete();
            }
            $category->delete();
            return response()->json(['result' => 'ok']);
        }
        return response()->json(['result' => 'error']);
    }
    //
}
