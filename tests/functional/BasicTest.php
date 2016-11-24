<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class BasicTest extends TestCase
{
    use DatabaseMigrations;

    public function testBasicExample()
    {
        $this->visit('/')
             ->see('RobLeg');
    }
}
