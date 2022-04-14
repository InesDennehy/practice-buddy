<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="the practice tracker everyone needs">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
    <div id="app">
        <div>
            <nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel sticky-top custom-navbar">
                <div class="container">
                    <a class="navbar-brand" href="/home">
                        <img src="/images/icons/icon-128x128.png" style="width:35px; height:35px" alt="logo">
                        PracticeBuddy
                    </a>
                </div>
            </nav>

            <main class="py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card category border-0 shadow">
                                <img class="card-img-top no-pieces-filler" src="images/no-pieces-filler.png" alt="Image">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h4 class="display text-center">You are currently offline</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/general.css')}}" rel="stylesheet">
    <link href="{{asset('css/pieces.css')}}" rel="stylesheet">
    <link href="{{asset('css/categories.css')}}" rel="stylesheet">

</body>
</html>
