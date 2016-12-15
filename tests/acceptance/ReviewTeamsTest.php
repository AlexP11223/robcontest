<?php

use App\Models\Contest;
use App\Models\Team;

class ReviewTeamsTest extends TestCase
{
    /** @test */
    public function should_see_review_link_for_current_contest()
    {
        $contest = factory(Contest::class)->create();

        $this
            ->actingAs(self::admin())
            ->visit('/');

        $this->seeLink('Review teams', "/contests/$contest->urlSlug/review-teams");
    }

    /** @test */
    public function users_should_not_see_review_link()
    {
        factory(Contest::class)->create();

        $this->visit('/');

        $this->dontSeeLink('Review teams');
    }

    /** @test */
    public function can_see_team_list()
    {
        $contest = factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);
        $teams = factory(Team::class, 3)->create([ 'contest_id' => $contest->id ])
                ->each(function(Team $t) {
                    $t->addMember(factory(\App\Models\TeamMember::class)->create());
                    $t->addMember(factory(\App\Models\TeamMember::class)->create());
                });

        $this
            ->actingAs(self::admin())
            ->visit("contests/$contest->urlSlug/review-teams");

        $this->see('Review teams');
        $this->see($contest->name);

        foreach ($teams as $team) {
            $this
                ->see($team->name)
                ->see($team->teacher_first_name)
                ->see($team->teacher_last_name)
                ->see($team->email)
                ->see($team->members[0]->first_name)
                ->see($team->members[0]->last_name)
                ->see($team->members[1]->first_name)
                ->see($team->members[1]->last_name);
        }
    }

    /** @test */
    public function can_approve_team()
    {
        $contest = factory(Contest::class)->create();
        $team = factory(Team::class)->create([ 'contest_id' => $contest->id ]);

        $this
            ->actingAs(self::admin())
            ->patch("teams/$team->id/approve");

        $this->assertResponseOk();

        $this->seeInDatabase('teams', [
            'id' => $team->id,
            'approved' => true
        ]);
    }

    /** @test */
    public function can_deny_team()
    {
        $contest = factory(Contest::class)->create();
        $team = factory(Team::class)->create([ 'contest_id' => $contest->id ]);

        $this
            ->actingAs(self::admin())
            ->patch("teams/$team->id/deny");

        $this
            ->assertResponseNot500()
            ->assertResponseOk();

        $this->seeInDatabase('teams', [
            'id' => $team->id,
            'approved' => false
        ]);
    }

    /** @test */
    public function users_cannot_approve_deny_team()
    {
        $contest = factory(Contest::class)->create();
        $team = factory(Team::class)->create([ 'contest_id' => $contest->id ]);

        $this->patch("teams/$team->id/approve")
            ->seeStatusCode(403);
        $this->patch("teams/$team->id/deny")
            ->seeStatusCode(403);
    }

    public static function teamStatuses()
    {
        return array(
            array(null, 'waiting'),
            array(true, 'approved'),
            array(false, 'denied'),
        );
    }

    /** @test
     * @dataProvider teamStatuses
     */
    public function should_see_team_status($approved, $text)
    {
        $contest = factory(Contest::class)->create();
        $team = factory(Team::class)->create([
            'contest_id' => $contest->id,
            'approved' => $approved
        ]);

        $this
            ->actingAs(self::admin())
            ->visit("contests/$contest->urlSlug/review-teams");

        $this->seeInElement('.team-status', $text);
    }
}
