
<?php

use App\Models\Contest;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SeeContestListTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_see_contests_on_main_page()
    {
        $this->visit('/');

        $this->assertViewHas('currentContest');
        $this->assertViewHas('archivedContests');

        $contest = $this->viewData('currentContest');
        $archivedContests = $this->viewData('archivedContests');

        $this->assertCount(Contest::count() - 1, $archivedContests);

        $this->seeLink($contest->name, '/contests/' . $contest->urlSlug);

        foreach ($archivedContests as $archivedContest) {
            $this->seeLink($archivedContest->name);

            $this->seeLink($archivedContest->name, '/contests/' . $archivedContest->urlSlug);
        }
    }

    /** @test */
    public function can_open_contest_pages()
    {
        $this->visit('/');

        $contest = $this->viewData('currentContest');
        $archivedContests = $this->viewData('archivedContests');

        $this->assertCount(Contest::count() - 1, $archivedContests);

        $this
            ->visit('/contests/' . $contest->urlSlug)
            ->assertResponseOk()
            ->see($contest->name);

        foreach ($archivedContests as $archivedContest) {
            $this
                ->visit('/contests/' . $archivedContest->urlSlug)
                ->assertResponseOk()
                ->see($archivedContest->name);
        }
    }
}
