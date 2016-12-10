<div data-post-title="{{ $post->title }}" class="post">
    <div class="post-content">
        <a class="h2 post-title" href="posts/{{ $post->id }}">
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
        </div>

        <script src="/js/post.js"></script>
    @endif
</div>
