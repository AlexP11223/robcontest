<?php

class BasicTest extends TestCase
{
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('RobLeg');
    }
}
