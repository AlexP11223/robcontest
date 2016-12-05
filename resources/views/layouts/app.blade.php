<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="/css/app.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid main-container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <header class="page-header">
                <div class="col-padding media">
                    <a href="/" class="media-left">
                        <img src="/img/logo.png"/>
                    </a>
                    <h1 class="media-body">{{ config('app.name') }}</h1>
                </div>
            </header>
        </div>
    </div>

    <div class="row">
        <section class="col-md-8 col-md-push-2">
            <div class="col-padding">
                <section>
                    <script src="/js/common.js"></script>

                    @yield('content')
                </section>
            </div>
        </section>

        <section class="col-md-2 col-md-pull-8">
            <div class="user-menu">
                <div class="user-menu-item">
                    <a href="{{ url('/info') }}" role="button" class="btn btn-primary btn-block">
                        <span class="glyphicon glyphicon-info-sign"></span>
                        Information
                    </a>
                </div>
                <div class="user-menu-item">
                    <a href="/" role="button" class="btn btn-primary btn-block">
                        <span class="glyphicon glyphicon-file"></span>
                        Apply
                    </a>
                </div>

                @if (Auth::check())
                    @if (Auth::user()->hasRole('admin'))
                        <div id="adminMenu">
                            <div class="user-menu-item">
                                <a href="/" role="button" class="btn btn-primary btn-block">
                                    <span class="glyphicon glyphicon-check"></span>
                                    Review teams
                                </a>
                            </div>
                            <div class="user-menu-item">
                                <a href="/" role="button" class="btn btn-primary btn-block">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    Add post
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="user-menu-item">
                        <strong>{{ Auth::user()->name }}</strong>

                        <div>
                            <a href="{{ route('change-password') }}" role="button">
                                Change password
                            </a>
                        </div>

                        <div>
                            <form action="{{ route('logout') }}" class="logout-form" method="post">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-link">Logout</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </section>

    </div>
</div>

</body>
</html>
