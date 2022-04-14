<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Session;
use Illuminate\Support\Carbon;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index(){
        $categories = Category::where('user_id', Auth::user()->id)->select('name', 'id')->get();
        return response()->json(['categories' => $categories]);
    }

    public function store(){
        request()->validate([
            'category_name' => 'required', Rule::unique('categories', 'name')->where('user_id', Auth::user()->id),
        ]);
        $category = Category::create([
            'name' => request('category_name'),
            'user_id' => Auth::user()->id,
        ]);
        return response()->json(['status' => 'OK', 'category' => $category]);
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
