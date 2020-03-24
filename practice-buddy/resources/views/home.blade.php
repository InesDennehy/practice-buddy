@extends('layouts.app')

@section('content')
    <window username={{Auth::user()->name}} logout_route={{ route('logout') }}></window>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endsection

@section('styles')
    <link href="{{asset('css/pieces.css')}}" rel="stylesheet">
    <link href="{{asset('css/categories.css')}}" rel="stylesheet">
@endsection
