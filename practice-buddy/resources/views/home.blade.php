@extends('layouts.app')

@section('content')
    @foreach ($categories as $category)
        <category category_name={{$category->name}} :initial_pieces=[]></category>
    @endforeach
@endsection
