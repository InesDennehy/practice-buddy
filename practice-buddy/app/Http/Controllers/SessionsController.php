<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use App\Piece;
use App\Session;
use Illuminate\Support\Facades\DB;

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

    public function data($days){
        $sessions = DB::table('sessions')
            ->join('pieces', 'sessions.piece_id', '=', 'pieces.id')
            ->join('categories', 'pieces.category_id', '=', 'categories.id')
            ->select(DB::raw('DATE_FORMAT(sessions.created_at, "%d-%b-%Y") as created_at'), 'categories.user_id', 'categories.name as category_name', 'pieces.name as piece_name')
            ->where('categories.user_id', Auth::user()->id)
            ->whereBetween('sessions.created_at', [Carbon::now()->subDays($days-1), Carbon::now()])
            ->get();
        $period = CarbonPeriod::create(Carbon::now()->subDays($days-1), Carbon::now());
        // Iterate over the period
        $dates = [];
        foreach ($period as $date) {
            array_push($dates, $date->format('d-M-Y'));
        }
        // Convert the period to an array of dates

        return response()->json(['data' => $sessions, 'days' => $dates]);
    }
}
