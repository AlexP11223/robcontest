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
            @include('menu')
        </section>

    </div>
</div>

</body>
</html>
