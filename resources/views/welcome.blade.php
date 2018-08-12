<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="google-site-verification" content="S0VR4HXWxYcwebMQxarTHx-r6CjZwxmcKmbamC3exGI">

        <title>@lang(config('app.name'))</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            footer {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                text-align: center;
                padding-bottom: 20px;
            }
            footer a {
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">@lang('Home')</a>
                    @else
                        <a href="{{ route('login') }}">@lang('Login')</a>
                        <a href="{{ route('register') }}">@lang('Register')</a>
                    @endauth
                </div>
            @endif

            <div class="content">

                @include('crud::partials.messages')

                <div class="title m-b-md">
                    @lang(config('app.name'))
                </div>

                <div class="links">
                    <a href="{{ route('doc') }}">Anleitung</a>
                    <a href="https://skills-store.amazon.de/deeplink/dp/B07BKR4J8F?deviceType=app&share&refSuffix=ss_copy">Alexa-Skill für Amazon Echo</a>
                    <a href="{{ route('published') }}">Veröffentliche Geschichten</a>
                    <a href="/forums">Forum</a>
                </div>
            </div>

            <footer>
                <a href="{{ route('terms') }}">Nutzungsbedingungen</a>
                &middot; <a href="{{ route('privacy') }}">Datenschutz</a>
            </footer>
        </div>
    </body>
</html>
