<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function data(){
        request()->validate([
            'days' => 'required',
            'offset' => 'required',
        ]);
        $days = request('days');
        $offset = request('offset');
        $lastDay = Carbon::now()->addDays($offset*$days);
        $firstDay = Carbon::now()->addDays($offset*$days)->subDays($days-1);
        $sessions = DB::table('sessions')
            ->join('pieces', 'sessions.piece_id', '=', 'pieces.id')
            ->join('categories', 'pieces.category_id', '=', 'categories.id')
            ->select(DB::raw("to_char(sessions.created_at, 'DD-Mon-YYYY') as created_at"), 'categories.user_id', 'categories.name as category_name', 'pieces.name as piece_name')
            ->where('categories.user_id', Auth::user()->id)
            ->whereBetween('sessions.created_at', [$firstDay, $lastDay])
            ->get();
        $period = CarbonPeriod::create($firstDay, $lastDay->addDay());
        // Iterate over the period
        $dates = [];
        foreach ($period as $date) {
            array_push($dates, $date->format('d-M-Y'));
        }
        // Convert the period to an array of dates

        return response()->json(['data' => $sessions, 'days' => $dates, 'firstDay' => $firstDay, 'lastDay' => $lastDay]);
    }
}
