<?php

use App\Models\Contest;
use App\Models\Team;

class CreateContestTest extends TestCase
{
    /** @test */
    public function can_see_create_link()
    {
        $this
            ->actingAs(self::admin())
            ->visit('/');

        $this->seeLink('Create contest', "/contests/create");
    }

    /** @test */
    public function users_should_not_see_create_link()
    {
        factory(Contest::class)->create();

        $this->visit('/');

        $this->dontSeeLink('Create contest');
    }

    /** @test */
    public function can_create_contest()
    {
        $this
            ->actingAs(self::admin())
            ->visit('contests/create');

        $this
            ->see('Create contest')
            ->seeInElement('button[type="submit"]', 'Create');

        $this->post('contests', [
            'contestName' => 'RobLeg 2001',
        ]);

        $this
            ->assertRedirectedTo('/')
            ->assertSessionHasNoErrors();

        $this->seeInDatabase('contests', [
            'name' => 'RobLeg 2001',
            'registration_finished' => false
        ]);

        $this
            ->visit('/')
            ->see('RobLeg 2001');
    }

    /** @test */
    public function cannot_create_existing_contest()
    {
        $this
            ->actingAs(self::admin())
            ->visit('contests/create');

        $this->post('contests', [
            'contestName' => 'RobLeg 2001'
        ]);

        $this
            ->assertRedirectedTo('/')
            ->assertSessionHasNoErrors();

        $this->visit('contests/create');

        $this->post('contests', [
            'contestName' => 'RobLeg 2001'
        ]);

        $this
            ->assertRedirectedTo('contests/create')
            ->assertSessionHasErrors(['contestName']);
    }

    /** @test */
    public function cannot_create_with_incorrect_input()
    {
        $this
            ->actingAs(self::admin())
            ->visit('contests/create');

        $this->post('contests', []);

        $this
            ->assertRedirectedTo('contests/create')
            ->assertSessionHasErrors(['contestName']);
    }

    /** @test */
    public function users_cannot_create_contest()
    {
        $this->post('contests', [
            'contestName' => 'RobLeg 2001',
        ]);

        $this->assertResponseStatus(403);
    }

}
