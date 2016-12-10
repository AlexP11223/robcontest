<div data-post-title="{{ $post->title }}" data-post-url="{{ route('posts.show', [$post->id]) }}" class="post">
    <div class="post-content">
        <a class="h2 post-title" href="{{ route('posts.show', [$post->id]) }}">
            {{ $post->title }}
        </a>
        <p class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</p>

        <div class="post-maincontent">
            {!! $post->html() !!}
        </div>
    </div>

    @if (Auth::check() && Auth::user()->hasRole('admin'))
        <div class="post-actions">
            <a href="{{ route('posts.edit', [$post->id]) }}">edit</a>

            <a data-action="deletePost" href="#">delete</a>

            <div class="postaction-loading-indicator" style="display: none">
                <img  src="/img/ajax-loader.gif" />
            </div>
        </div>
    @endif
</div>
