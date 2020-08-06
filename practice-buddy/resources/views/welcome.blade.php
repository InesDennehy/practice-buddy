@extends('layouts.app')
@section('content')
    <div class="top-panel my-auto h-100 w-100 d-table">
        <div class="d-table-cell align-middle text-center">
            <div style="margin-bottom: 30px"><img src="{{asset('images/icons/icon-152x152.png')}}"></div>
            <h1 class="display-3 text-center title">Welcome to Practice Buddy</h1>
            <h2 class="text-center">The practice tracker everyone needs</h2>
            <div class="py-4">
                <a href="#bottom-panel" onclick="
                    event.preventDefault();
                    $('html, body').animate({
                            scrollTop: $(hash).offset().top
                    }, 100, function(){
                        });
                ">
                    <button class="button center slide"></button>
                </a>
            </div>
        </div>
    </div>
    <div class="row bottom-panel h-100 w-100" id="bottom-panel">
        <div class="col md-6 login-div">
            @include('auth.login')
        </div>
        <div class="col md-6 register-div">
            @include('auth.register')
        </div>
    </div>
@endsection
@section('styles')
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endsection
