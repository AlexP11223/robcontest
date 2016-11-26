<?php

use App\Models\User;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @return App\Models\User
     */
    protected static function admin()
    {
        return User::whereName('admin')->first();
    }

    protected static function defaultAdminPassword() {
        return "pass123";
    }

    protected function sessionHasNoErrors()
    {
        $this->assertSessionMissing('errors');
    }
}
