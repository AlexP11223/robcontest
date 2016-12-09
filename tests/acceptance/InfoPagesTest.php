<?php

class InfoPagesTest extends TestCase
{
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
