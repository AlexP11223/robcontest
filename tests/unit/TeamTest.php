<?php

use App\Models\TeamMember;
use App\Models\Team;

class TeamTest extends TestCase
{
    /** @test */
    public function can_create_team_with_members()
    {
        $member1 = factory(TeamMember::class)->create();
        $member2 = factory(TeamMember::class)->create();

        $team = factory(Team::class)->create();

        $team->addMember($member1);
        $team->addMember($member2);

        $team = $team->fresh();

        $this->assertCount(2, $team->members);
    }

    /** @test */
    public function returns_status_text()
    {
        $team = factory(Team::class)->make();

        self::assertEquals('waiting', $team->statusText());

        $team->approved = true;

        self::assertEquals('approved', $team->statusText());

        $team->approved = false;

        self::assertEquals('denied', $team->statusText());
    }
}
