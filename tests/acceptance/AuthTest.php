<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;

class AuthTest extends TestCase
{
    public static function adminPages()
    {
        return array(
            array('posts/create', 'Create post'),
            array('posts/1/edit', 'Edit post'),
            array('change-password', 'Change password'),
            array('contests/robleg-2016/review-teams', 'Review teams'),
        );
    }

    public static function incorrectLoginParameters()
    {
        return array(
            array([]),
            array(['name' => 'admin', 'password' => 'incorrect']),
        );
    }

    /** @test */
    public function admin_can_log_in()
    {
        $this->post('admin-login', ['name' => 'admin', 'password' => $this->defaultAdminPassword()]);

        $this
            ->assertRedirectedTo('/')
            ->assertSessionHasNoErrors();

        $this
            ->visit('/')
            ->see('Logout');
    }

    /** @test
     *  @dataProvider incorrectLoginParameters
     */
    public function cannot_log_in_without_valid_credentials($params)
    {
        $this->visit('admin-login');

        $this->post('admin-login', $params);

        $this
            ->assertRedirectedTo('admin-login')
            ->assertSessionHasErrors();
    }

    /** @test
     *  @dataProvider adminPages
     */
    public function admin_can_access_admin_pages($page, $pageContent)
    {
        $this
            ->actingAs($this->admin())
            ->visit($page)
            ->see($pageContent);

    }

    /** @test
     *  @dataProvider adminPages
     */
    public function users_cannot_access_admin_pages($page)
    {
        $this
            ->get($page)
            ->assertRedirectedToRoute('login');
    }
}
