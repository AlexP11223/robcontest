<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class SeePostsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_see_posts_on_main_page()
    {
        $this->visit('/');

        $this->assertViewHas('posts');

        $posts = $this->viewData('posts');

        $this->assertCount(10, $posts);

        $prevPost = null;

        foreach ($posts as $post) {
            $this->see($post->title);

            if ($prevPost) {
                $this->assertTrue($post->created_at->lt($prevPost->created_at), 'Not sorted');
            }
            $prevPost = $post;
        }

        $this->seeElement('.pagination');
    }

    /** @test */
    public function can_see_posts_on_previous_pages()
    {
        $this->visit('/?page=2');

        $this->assertViewHas('posts');

        $posts = $this->viewData('posts');

        $this->assertLessThan(10, count($posts));

        $prevPost = null;

        foreach ($posts as $post) {
            $this->see($post->title);

            if ($prevPost) {
                $this->assertTrue($post->created_at->lt($prevPost->created_at), 'Not sorted');
            }
            $prevPost = $post;
        }

        $this->seeElement('.pagination');
    }

    /** @test */
    public function can_open_single_post()
    {
        $this->visit('/posts/1');

        $this->assertViewHas('post');

        $post = $this->viewData('post');

        $this->see($post->title);
    }
}
