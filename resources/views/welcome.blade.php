<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Coaster Park Nerd</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .about {
                font-size: 24px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                        <a href="{{ url('/about') }}">About</a>
                        <a href="{{ url('/privacy') }}">Privacy</a>
                        <a href="{{ url('/terms') }}">Terms & Conditions</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        <!-- @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif -->

                        <a href="{{ url('/about') }}">About</a>
                        <a href="{{ url('/privacy') }}">Privacy</a>
                        <a href="{{ url('/terms') }}">Terms & Conditions</a>

                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Coaster Park Nerd
                </div>

                <div class="about m-b-md">

                    Keep track of your park visits, rides, dates.<br>
                    Rate your experience.<br>
                    Track the time you waited in line.<br>
                    Gather data and see what your wait times, ratings, and comments have been like.<br>
                    Compete with others to get the most park visits and rides!

                </div>

                <div class="about m-b-md">

                    <img src="{{ asset('img/image02119.png') }}" width=150px height=200px>
                    <img src="{{ asset('img/image03 147.png') }}" width=150px height=200px>
                    <img src="{{ asset('img/image04 205.png') }}" width=150px height=200px>
                    <img src="{{ asset('img/image05 230.png') }}" width=150px height=200px>
                    <img src="{{ asset('img/image06 349.png') }}" width=150px height=200px>


                </div>

                <div class="about m-b-md">

                    Download the Coaster Park Nerd app from the Google Play Store

                </div>

            </div>
        </div>

    </body>

</html>
