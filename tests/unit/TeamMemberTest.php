<?php

use App\Models\TeamMember;
use Carbon\Carbon;

class TeamMemberTest extends TestCase
{
    /** @test */
    public function returns_age()
    {
        $teamMember = factory(TeamMember::class)->create([
            'dob' => Carbon::now()->subYears(8)
        ]);

        $this->assertSame(8, $teamMember->age());
    }
}
