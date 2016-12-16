  @extends('layouts.app')

@section('content')

    <div>
        @if(isset($currentContest))
            <div class="contest-list">
                <p>
                    <a class="contest-link active-contest" href="{{ route('contests.show', [$currentContest->urlSlug]) }}">{{ $currentContest->name }}</a>
                </p>
            </div>
        @endif

        <p class="archive-link">
            <a class="lead dotted-link" href="javascript:void(0)" id="archiveBtn">Archive</a>
        </p>
        <div  class="contest-list">
            <div id="archive" style="display:none;">
                @foreach($archivedContests as $contest)
                    <ul>
                        <li class="contest-link"><a href="{{ route('contests.show', [$contest->urlSlug]) }}">{{ $contest->name }}</a></li>
                    </ul>
                @endforeach
            </div>
        </div>
    </div>

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

    <script src="/js/home.js"></script>

@endsection
