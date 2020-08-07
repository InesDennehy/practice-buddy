<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="the practice tracker everyone needs">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Laravel') }}</title>
    @laravelPWA


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/general.css')}}" rel="stylesheet">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="top-panel my-auto h-100 w-100 d-table">
            <div class="d-table-cell align-middle text-center">
                <div style="margin-bottom: 30px"><img alt="logo" src="{{asset('images/icons/icon-152x152.png')}}"></div>
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
                        <button aria-label="learn more" class="button center slide"></button>
                    </a>
                </div>
            </div>
        </div>
        <div class="row bottom-panel w-100 container-fluid" id="bottom-panel">
            <div class="col md-6 login-div">
                @include('auth.login')
            </div>
            <div class="col md-6 register-div">
                @include('auth.register')
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
