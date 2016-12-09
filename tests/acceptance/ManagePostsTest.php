<?php

use App\Models\Post;

class ManagePostsTest extends TestCase
{
    /** @test */
    public function can_create_post()
    {
        $title = 'New post';
        $content = str_repeat('New post content', 20);

        $this
            ->actingAs(self::admin())
            ->visit('posts/create');

        $this
            ->see('Create post')
            ->seeInElement('button[type="submit"]', 'Create');

        $this->post('posts', [
            'title' => $title,
            'content' => $content
        ]);

        $this
            ->assertRedirectedTo('/')
            ->assertSessionHasNoErrors();

        $this->seeInDatabase('posts', [
            'title' => $title,
            'content' => $content
        ]);

        $this
            ->visit('/')
            ->see($title);
    }

    /** @test */
    public function can_update_post()
    {
        $title = 'New post 1';
        $content = str_repeat('New post 1 content', 20);

        $this
            ->actingAs(self::admin())
            ->visit('posts/1/edit');

        $post = Post::find(1);

        $this
            ->see('Edit post')
            ->seeInElement('button[type="submit"]', 'Update')
            ->seeInField('title', $post->title)
            ->seeInField('content', $post->content);

        $this->put('posts/1', [
            'title' => $title,
            'content' => $content
        ]);

        $this
            ->assertRedirectedTo('/posts/1')
            ->assertSessionHasNoErrors();

        $this->seeInDatabase('posts', [
            'id' => 1,
            'title' => $title,
            'content' => $content
        ]);

        $this
            ->visit('/posts/1')
            ->see($title);
    }

    /** @test */
    public function cannot_create_empty_post()
    {
        $title = '';
        $content = '';

        $this
            ->actingAs(self::admin())
            ->visit('posts/create');

        $this->post('posts', [
            'title' => $title,
            'content' => $content
        ]);

        $this
            ->assertRedirectedTo('posts/create')
            ->assertSessionHasErrors(['title', 'content']);
    }

    /** @test */
    public function cannot_update_to_empty_post()
    {
        $title = '';
        $content = '';

        $this
            ->actingAs(self::admin())
            ->visit('posts/1/edit');

        $this->put('posts/1', [
            'title' => $title,
            'content' => $content
        ]);

        $this
            ->assertRedirectedTo('posts/1/edit')
            ->assertSessionHasErrors(['title', 'content']);
    }

    /** @test */
    public function should_trim_input()
    {
        $title = '      New post         ';
        $content = '            New post content                             ';

        $this
            ->actingAs(self::admin())
            ->visit('posts/create');

        $this->post('posts', [
            'title' => $title,
            'content' => $content
        ]);

        $this
            ->assertRedirectedTo('/')
            ->assertSessionHasNoErrors();

        $this->seeInDatabase('posts', [
            'title' => 'New post',
            'content' => 'New post content'
        ]);
    }

    /** @test */
    public function users_cannot_perform_admin_requests()
    {
        $this->post('posts')
            ->seeStatusCode(403);
        $this->put('posts/1')
            ->seeStatusCode(403);
        $this->patch('posts/1')
            ->seeStatusCode(403);
        $this->delete('posts/1')
            ->seeStatusCode(403);
    }
}
