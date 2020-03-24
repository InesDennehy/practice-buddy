@extends('layouts.app')
@section('content')
    <div class="top-panel my-auto h-100 w-100 d-table">
        <div class="d-table-cell align-middle">
            <h1 class="display-3 text-center">Welcome to Practice Buddy</h1>
            <h2 class="text-center">The practice tracker everyone needs</h2>
            <div class="py-4">
                <a href="#bottom-panel" onclick="
                    // Make sure this.hash has a value before overriding default behavior
                    if (this.hash !== '') {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 100, function(){
                    });
                    } // End if
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
