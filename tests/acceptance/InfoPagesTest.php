<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class InfoPagesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_open_info_page()
    {
        $this
            ->visit('/')
            ->seeLink('Information', '/info');

        $this
            ->visit('/info')
            ->see('Contact us');
    }
}
