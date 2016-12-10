<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Redirect;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
        $this->middleware('role:admin')->except(['show']);

        $this->middleware('trim')->only(['store', 'update']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.edit', ['isEditing' => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUpdatePost $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdatePost $request)
    {
        Post::create([
            'title' => $request['title'],
            'content' => $request['content']
        ]);

        return Redirect::to('/');
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.post', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', ['isEditing' => true, 'post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateUpdatePost $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdatePost $request, Post $post)
    {
        $post->update([
            'title' => $request['title'],
            'content' => $request['content']
        ]);

        return Redirect::route('posts.show', [$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return "ok";
    }
}
