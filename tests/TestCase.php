<?php

use App\Models\User;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use DatabaseSetup;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    protected function setUp()
    {
        parent::setUp();

        $this->setupDatabase();
    }

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

    /**
     * @return $this
     */
    protected function assertSessionHasNoErrors()
    {
        if ($this->app['session.store']->has('errors')) {
            self::fail("Session has unexpected errors " . json_encode($this->app['session.store']->get('errors')->all()));
        }
        return $this;
    }

    /**
     * @param $key string
     * @return mixed
     */
    protected function viewData($key) {
        return $this->response->original->$key;
    }

    /**
     * @return $this
     */
    protected function assertResponseNot500()
    {
        if ($this->response->status() >= 500) {
            self::fail($this->response->getContent() . "\n\n500 error");
        }

        return $this;
    }
}
