<?php

use App\Models\Contest;

class ContestTest extends TestCase
{
    /** @test */
    public function current_returns_latest_contest()
    {
        $oldContest = factory(Contest::class)->create([
            'name' => 'RobLeg 2000'
        ]);
        $newContest = factory(Contest::class)->create([
            'name' => 'RobLeg 2001'
        ]);

        $this->assertEquals($newContest->id, Contest::current()->id);
        $this->assertEquals($newContest->name, Contest::current()->name);
    }

    /** @test */
    public function returns_archived_contests()
    {
        $oldContests = factory(Contest::class, 2)->create();
        $newContest = factory(Contest::class)->create();

        $archivedContests = Contest::archived();

        $this->assertCount(Contest::count() - 1, $archivedContests);
        $this->assertFalse($archivedContests->contains($newContest), 'Has current contest');
        foreach ($oldContests as $oldContest) {
            $this->assertTrue($archivedContests->contains($oldContest), 'Does not have old contests');
        }
    }

    /** @test */
    public function has_slug_when_created()
    {
        $contest = Contest::create([
            'name' => 'RobLeg 2001',
            'isRegistrationFinished' => false,
        ]);

        $this->assertEquals('robleg-2001', $contest->urlSlug);
    }
}
