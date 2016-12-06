<div data-post-title="{{ $post->title }}" class="post">
    <div class="post-content">
        <a class="h2 post-title" href="posts/{{ $post->id }}">
            {{ $post->title }}
        </a>
        <p class="post-date">{{ $post->created_at }}</p>

        <div class="post-maincontent">
            {!! $post->html() !!}
        </div>
    </div>

    @if (Auth::check() && Auth::user()->hasRole('admin'))
        <div class="post-actions">
            <a data-action="editPost">edit</a>

            <a data-action="deletePost" href="#">delete</a>
        </div>
    @endif
</div>
