<?php

use App\Models\Contest;
use Carbon\Carbon;

class TeamApplyTest extends TestCase
{
    private $validInput;

    protected function setUp()
    {
        parent::setUp();

        $this->validInput = [
            'team' => 'New team',
            'school' => 'School name',
            'member1_first_name' => 'Member1 first name',
            'member1_last_name' => 'Member1 last name',
            'member1_dob' => Carbon::today()->subYears(8)->format('Y-m-d'),
            'member2_first_name' => 'Member2 first name',
            'member2_last_name' => 'Member2 last name',
            'member2_dob' => Carbon::today()->subYears(11)->format('Y-m-d'),
            'teacher_first_name' => 'Teacher first name',
            'teacher_last_name' => 'Teacher last name',
            'email' => 'teacher@school.edu',
            'phone' => '37012345678',
            'sumo' => 'on',
            'obstacles' => 'on',
        ];
    }

    /** @test */
    public function should_see_apply_link_when_registration_opened()
    {
        factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);

        $this->visit('/');

        $this->seeLink('Apply', '/apply');
    }

    /** @test */
    public function should_not_see_apply_link_when_registration_finished()
    {
        factory(Contest::class)->create([
            'isRegistrationFinished' => true
        ]);

        $this->visit('/');

        $this->dontSeeLink('Apply', '/apply');
    }

    /** @test */
    public function apply_page_should_not_work_when_registration_finished()
    {
        factory(Contest::class)->create([
            'isRegistrationFinished' => true
        ]);

        $this
            ->get('apply')
            ->assertResponseStatus(404);
    }

    /** @test */
    public function cannot_apply_when_registration_finished()
    {
        factory(Contest::class)->create([
            'isRegistrationFinished' => true
        ]);

        $this
            ->post('apply', $this->validInput)
            ->assertResponseStatus(403);
    }

    /** @test */
    public function can_apply()
    {
        $contest = factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);

        $this->visit('apply');

        $this
            ->see('Apply for contest')
            ->dontSeeElement('.success-confirmation');

        $data = $this->validInput;

        $this->post('apply', $data);

        $this
            ->assertResponseNot500()
            ->assertRedirectedTo('apply')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success', true);
        $this
            ->get('apply')
            ->seeElement('.success-confirmation');

        self::assertCount(1, $contest->teams);

        $team = $contest->teams[0];

        self::assertEquals($data['team'], $team->name);
        self::assertEquals($data['school'], $team->school);
        self::assertEquals($data['email'], $team->email);
        self::assertEquals($data['phone'], $team->phone);
        self::assertEquals($data['teacher_first_name'], $team->teacher_first_name);
        self::assertEquals($data['teacher_last_name'], $team->teacher_last_name);
        self::assertEquals(true, $team->sumo);
        self::assertEquals(true, $team->obstacles);

        self::assertCount(2, $team->members);

        self::assertEquals($data['member1_first_name'], $team->members[0]->first_name);
        self::assertEquals(Carbon::today()->subYears(8), $team->members[0]->dob);
        self::assertEquals($data['member1_last_name'], $team->members[0]->last_name);
        self::assertEquals($data['member2_first_name'], $team->members[1]->first_name);
        self::assertEquals($data['member2_last_name'], $team->members[1]->last_name);
        self::assertEquals(Carbon::today()->subYears(11), $team->members[1]->dob);
    }

    /** @test */
    public function trima_input()
    {
        $contest = factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);

        $this->visit('apply');

        $data = $this->validInput;
        $data['team'] = '  team name      ';
        $data['member1_first_name'] = '  first name      ';

        $this->post('apply', $data);

        $this
            ->assertResponseNot500()
            ->assertRedirectedTo('apply')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success', true);

        $team = $contest->teams[0];

        self::assertEquals('team name', $team->name);

        self::assertCount(2, $team->members);

        self::assertEquals('first name', $team->members[0]->first_name);
    }

    /** @test */
    public function can_apply_without_optional_params()
    {
        $contest = factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);

        $this->visit('apply');

        $data = $this->validInput;
        unset($data['school']);
        unset($data['obstacles']);

        $this->post('apply', $data);

        $this
            ->assertResponseNot500()
            ->assertRedirectedTo('apply')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success', true);
        $this
            ->get('apply')
            ->seeElement('.success-confirmation');

        $team = $contest->teams[0];

        self::assertEquals(null, $team->school);
        self::assertEquals(true, $team->sumo);
        self::assertEquals(false, $team->obstacles);
    }

    /** @test */
    public function cannot_apply_without_valid_input()
    {
        $contest = factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);

        $this->visit('apply');

        $this->post('apply', [
            'phone' => 'abc1',
            'team' => 's',
            'email' => 'not-email',
            'member2_dob' => '99/99-99'
        ]);

        $this
            ->assertResponseNot500()
            ->assertRedirectedTo('apply')
            ->assertSessionHasErrors(['team', 'email', 'phone', 'sumo', 'obstacles',
                'member1_first_name', 'member1_last_name', 'member1_dob', 'member2_first_name', 'member2_last_name', 'member2_dob',
                'teacher_first_name', 'teacher_last_name'
            ]);
        $this
            ->get('apply')
            ->dontSeeElement('.success-confirmation');

        self::assertCount(0, $contest->teams);
    }

    /** @test */
    public function cannot_apply_if_not_eligible_agw()
    {
        $contest = factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);

        $data = $this->validInput;
        $data['member1_dob'] = Carbon::today()->subYears(3)->format('Y-m-d');
        $data['member2_dob'] = Carbon::today()->subYears(14)->format('Y-m-d');

        $this->visit('apply');

        $this->post('apply', $data);

        $this
            ->assertResponseNot500()
            ->assertRedirectedTo('apply')
            ->assertSessionHasErrors(['member1_dob', 'member2_dob']);
        $this
            ->get('apply')
            ->dontSeeElement('.success-confirmation');

        self::assertCount(0, $contest->teams);
    }

    /** @test */
    public function cannot_apply_if_team_already_exists_in_this_contest()
    {
        factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);

        $data = $this->validInput;
        $data['team'] = 'team name';

        $this->visit('apply');
        $this->post('apply', $data);

        $this
            ->assertResponseNot500()
            ->assertRedirectedTo('apply')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success', true);

        $this->visit('apply');
        $this->post('apply', $data);

        $this
            ->assertResponseNot500()
            ->assertRedirectedTo('apply')
            ->assertSessionHasErrors(['team']);


        $data['team'] = 'teAm NaMe';

        $this->visit('apply');
        $this->post('apply', $data);

        $this
            ->assertResponseNot500()
            ->assertRedirectedTo('apply')
            ->assertSessionHasErrors(['team']);


        factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);

        $this->visit('apply');
        $this->post('apply', $data);

        $this
            ->assertResponseNot500()
            ->assertRedirectedTo('apply')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success', true);
    }
}
