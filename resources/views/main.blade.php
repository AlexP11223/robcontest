@extends('layouts.app')

@section('content')

    @include('posts.list')

    <script>
        $(document).ready(function() {
            //  menu on top for mobile for the main page

            var menuCol = $('.user-menu').parent();
            var contentCol = $(menuCol.parent().children()[0]);

            contentCol.removeClass('col-md-push-2');
            menuCol.removeClass('col-md-pull-8');

            menuCol.prependTo(menuCol.parent());
        });
    </script>

@endsection
