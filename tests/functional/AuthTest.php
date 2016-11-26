<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public static function adminPages()
    {
        return array(
            array('/home'),
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
        $this->call('POST', '/admin-login', ['name' => 'admin', 'password' => $this->defaultAdminPassword()]);

        $this
            ->assertRedirectedTo('/home')
            ->sessionHasNoErrors();

        $this
            ->visit('/home')
            ->see('Logged in');
    }

    /** @test
     *  @dataProvider incorrectLoginParameters
     */
    public function cannot_log_in_without_valid_credentials($params)
    {
        $this->visit('/admin-login');

        $this->call('POST', '/admin-login', $params);

        $this
            ->assertRedirectedTo('/admin-login')
            ->assertSessionHasErrors();
    }

    /** @test
     *  @dataProvider adminPages
     */
    public function admin_can_access_admin_pages($page)
    {
        $this
            ->actingAs($this->admin())
            ->visit($page)
            ->see('Dashboard');

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
