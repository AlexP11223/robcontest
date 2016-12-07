@extends('layouts.app')

@section('content')
    <div class="col-md-10 no-padding-col">
        <h2>{{ $isEditing ? 'Edit post' : 'Create post' }}</h2>

        @if (count($errors) > 0)
            <div>
                <ul class="error list-no-indent">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form role="form" method="POST" action="{{ $isEditing ? route('posts.update', [$post->id]) : route('posts.store') }}" id="postForm">
            @if($isEditing)
                {{ method_field('PUT') }}
            @endif
            {{ csrf_field() }}

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $isEditing ? $post->title : '' }}"/>
            </div>

            <div class="form-group wmd-panel">
                <div id="wmd-button-bar"></div>
                <textarea class="wmd-input" id="wmd-input" name="content">{{ $isEditing ? $post->content : '' }}</textarea>
                <div id="wmd-preview" class="wmd-panel wmd-preview"></div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <button id="submitBtn" type="submit" class="btn btn-block btn-default">{{ $isEditing ? 'Update' : 'Create' }}</button>
                </div>
            </div>

        </form>
    </div>

    <script src="/js/postedit.js"></script>

    <script type="text/javascript">
        (function () {
            getPagedownEditor().run();
        })();
    </script>
@endsection
