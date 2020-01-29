<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Auth;

class CategoriesController extends Controller
{
    public function index(){
        return response()->json(['categories' => Auth::user()->categories]);
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
