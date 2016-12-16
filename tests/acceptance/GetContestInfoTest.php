
<?php

use App\Models\Contest;
use App\Models\Team;

class GetContestInfoTest extends TestCase
{
    /** @test */
    public function can_get_team_list()
    {
        $contest = factory(Contest::class)->create();
        $teams = factory(Team::class, 2)->create([
            'contest_id' => $contest->id
        ]);

        $this
            ->actingAs(self::admin())
            ->get("contests/$contest->urlSlug/teams");

        $this->assertResponseOk();

        foreach ($teams as $team) {
            $this->seeJson([
                'id' => $team->id,
                'name' => $team->name,
            ]);
        }
    }

    /** @test */
    public function only_admin_can_get_full_team_list()
    {
        $contest = factory(Contest::class)->create();
        $teams = factory(Team::class, 2)->create([
            'contest_id' => $contest->id
        ]);

        $this->get("contests/$contest->urlSlug/teams");

        $this->assertRedirectedToRoute('login');
    }
}
