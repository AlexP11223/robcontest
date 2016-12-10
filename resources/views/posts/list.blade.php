<div id="postsContainer">
    @foreach($posts as $post)
        @include('posts.post-content')
    @endforeach

    {{ $posts->links() }}

    <script src="/js/post.js"></script>
</div>
