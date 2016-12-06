<div id="postsContainer">
    @foreach($posts as $post)
        @include('posts.post-content')
    @endforeach

    {{ $posts->links() }}
</div>
