<?php

use App\Models\Contest;
use App\Models\Team;
use App\Models\TeamMember;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// adds some contests and results. This is included in migration because it is just a project for learning and
// we need some initial data after deployment
class AddInitialContests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Contest::unguard();
        Team::unguard();
        TeamMember::unguard();

        Carbon::setTestNow(Carbon::create(2016, 1, 1));

        $prevContest = Contest::create([
            'name' => 'RobLeg 2016',
            'isRegistrationFinished' => true,
            'created_at' => '2016-01-01 07:15:20',
        ]);
        $currContest = Contest::create([
            'name' => 'RobLeg 2017',
            'isRegistrationFinished' => false,
            'created_at' => '2016-12-15 09:15:20',
        ]);

        Team::create([
            'name' => 'Super Robots',
            'school' => 'School 1',
            'email' => 'john.smith123@gmail.com',
            'phone' => '37012345678',
            'teacher_first_name' => 'John',
            'teacher_last_name' => 'Smith',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Bill',
                'last_name' => 'Smith',
                'dob' => Carbon::today()->subYears(8)->subDays(55),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Joel',
                'last_name' => 'Gray',
                'dob' => Carbon::today()->subYears(11)->subDays(115),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Magic Robots',
            'school' => 'Hogwarts',
            'email' => 'albusd@hogwarts.edu',
            'phone' => '37012345678',
            'teacher_first_name' => 'Albus',
            'teacher_last_name' => 'Dumbledore',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Harry',
                'last_name' => 'Smith',
                'dob' => Carbon::today()->subYears(9)->subDays(42),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Bob',
                'last_name' => 'Green',
                'dob' => Carbon::today()->subYears(10)->subDays(205),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Cat Robots',
            'school' => 'School 8',
            'email' => 'taylor.j@sc8.edu',
            'phone' => '37012345678',
            'teacher_first_name' => 'Steve',
            'teacher_last_name' => 'Taylor',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Jack',
                'last_name' => 'Green',
                'dob' => Carbon::today()->subYears(9)->subDays(55),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Bob',
                'last_name' => 'Gray',
                'dob' => Carbon::today()->subYears(11)->subDays(58),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'RoboGirls',
            'email' => 's.smith@gmail.com',
            'phone' => '3701986578',
            'teacher_first_name' => 'Sarah',
            'teacher_last_name' => 'Smith',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Alice',
                'last_name' => 'Smith',
                'dob' => Carbon::today()->subYears(11)->subDays(15),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Carol',
                'last_name' => 'Green',
                'dob' => Carbon::today()->subYears(11)->subDays(200),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Cool Robots',
            'school' => 'School 1',
            'email' => 'john.smith123@gmail.com',
            'phone' => '37012345678',
            'teacher_first_name' => 'John',
            'teacher_last_name' => 'Smith',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Lucas',
                'last_name' => 'Smith',
                'dob' => Carbon::today()->subYears(8)->subDays(55),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Thomas',
                'last_name' => 'Gray',
                'dob' => Carbon::today()->subYears(11)->subDays(115),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Awesome Robots',
            'school' => 'School 6',
            'email' => 'wwalker74@gmail.com',
            'phone' => '37012345678',
            'teacher_first_name' => 'William',
            'teacher_last_name' => 'Walker',
            'sumo' => true,
            'obstacles' => false,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Jane',
                'last_name' => 'Brown',
                'dob' => Carbon::today()->subYears(10)->subDays(55),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Noah',
                'last_name' => 'Anderson',
                'dob' => Carbon::today()->subYears(8)->subDays(115),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Terminators',
            'school' => 'School 6',
            'email' => 'smartin@sc6.edu',
            'phone' => '37012345678',
            'teacher_first_name' => 'Samuel',
            'teacher_last_name' => 'Martin',
            'sumo' => true,
            'obstacles' => false,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Isaac',
                'last_name' => 'Robinson',
                'dob' => Carbon::today()->subYears(9)->subDays(42),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Xavier',
                'last_name' => 'Wood',
                'dob' => Carbon::today()->subYears(10)->subDays(205),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'RoboCops',
            'school' => 'School 6',
            'email' => 'kbrown@sc6.edu',
            'phone' => '37012345678',
            'teacher_first_name' => 'Kevin',
            'teacher_last_name' => 'Brown',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Mathew',
                'last_name' => 'Robinson',
                'dob' => Carbon::today()->subYears(8)->subDays(42),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'James',
                'last_name' => 'White',
                'dob' => Carbon::today()->subYears(10)->subDays(8),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Ninja Robots',
            'email' => 'ninjas89@yahoo.com',
            'phone' => '3708290676',
            'teacher_first_name' => 'Liam',
            'teacher_last_name' => 'Davis',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Bill',
                'last_name' => 'Green',
                'dob' => Carbon::today()->subYears(8)->subDays(142),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Charlie',
                'last_name' => 'Evans',
                'dob' => Carbon::today()->subYears(11)->subDays(56),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Uber Robots',
            'school' => 'School 1',
            'email' => 'bob.smith123@gmail.com',
            'phone' => '37012345678',
            'teacher_first_name' => 'Bob',
            'teacher_last_name' => 'Smith',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'David',
                'last_name' => 'Fisher',
                'dob' => Carbon::today()->subYears(8)->subDays(55),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Hugo',
                'last_name' => 'Black',
                'dob' => Carbon::today()->subYears(10)->subDays(15),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Cute Robots',
            'school' => 'School 1',
            'email' => 'bob.smith123@gmail.com',
            'phone' => '37068945678',
            'teacher_first_name' => 'Bob',
            'teacher_last_name' => 'Smith',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Phoebe',
                'last_name' => 'Brown',
                'dob' => Carbon::today()->subYears(9)->subDays(20),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Amy',
                'last_name' => 'Grant',
                'dob' => Carbon::today()->subYears(10)->subDays(105),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Atomic Robots',
            'school' => 'School 13',
            'email' => 'luke@sc13.edu',
            'phone' => '37012345678',
            'teacher_first_name' => 'Luke',
            'teacher_last_name' => "Garden",
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Max',
                'last_name' => 'Lewis',
                'dob' => Carbon::today()->subYears(9)->subDays(58),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Robert',
                'last_name' => 'Mason',
                'dob' => Carbon::today()->subYears(9)->subDays(45),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Tricky Robots',
            'email' => 'dan.86@gmail.com',
            'phone' => '37012345678',
            'teacher_first_name' => 'Daniel',
            'teacher_last_name' => 'Johnson',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Alan',
                'last_name' => 'Khan',
                'dob' => Carbon::today()->subYears(10)->subDays(28),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'John',
                'last_name' => 'Rose',
                'dob' => Carbon::today()->subYears(10)->subDays(105),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Alien Robots',
            'school' => 'School 1',
            'email' => 'j.smith123@gmail.com',
            'phone' => '37012345678',
            'teacher_first_name' => 'Jerry',
            'teacher_last_name' => 'Smith',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Kevin',
                'last_name' => 'Brown',
                'dob' => Carbon::today()->subYears(8)->subDays(55),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Bob',
                'last_name' => 'Smith',
                'dob' => Carbon::today()->subYears(10)->subDays(15),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Robots.Pro',
            'email' => 'natt1@gmail.com',
            'phone' => '3708936676',
            'teacher_first_name' => 'Nathan',
            'teacher_last_name' => 'Wolf',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Bill',
                'last_name' => 'Smith',
                'dob' => Carbon::today()->subYears(10)->subDays(143),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Luke',
                'last_name' => 'Green',
                'dob' => Carbon::today()->subYears(10)->subDays(56),
                'created_at' => '2016-01-02 07:15:20',
            ]));
        Team::create([
            'name' => 'Destroyers',
            'school' => 'School 1',
            'email' => 'john.smith123@gmail.com',
            'phone' => '37012345678',
            'teacher_first_name' => 'James',
            'teacher_last_name' => 'Thompson',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $prevContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Cooper',
                'last_name' => 'White',
                'dob' => Carbon::today()->subYears(11)->subDays(58),
                'created_at' => '2016-01-02 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Jim',
                'last_name' => 'Davis',
                'dob' => Carbon::today()->subYears(11)->subDays(56),
                'created_at' => '2016-01-02 07:15:20',
            ]));

        Carbon::setTestNow(Carbon::create(2016, 12, 16));

        Team::create([
            'name' => 'Mega Robots',
            'school' => 'School 8',
            'email' => 'taylor.j@sc8.edu',
            'phone' => '37012345678',
            'teacher_first_name' => 'Steve',
            'teacher_last_name' => 'Taylor',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $currContest->id,
            'approved' => true,
            'created_at' => '2016-12-16 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Alice',
                'last_name' => 'Green',
                'dob' => Carbon::today()->subYears(10)->subDays(55),
                'created_at' => '2016-12-16 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'John',
                'last_name' => 'Smith',
                'dob' => Carbon::today()->subYears(10)->subDays(86),
                'created_at' => '2016-12-16 07:15:20',
            ]));
        Team::create([
            'name' => 'qwertyjjj',
            'email' => 'hjjjjjjjj@gmail.com',
            'phone' => '37012345678',
            'teacher_first_name' => 'jjjj',
            'teacher_last_name' => 'jjjjj',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $currContest->id,
            'approved' => false,
            'created_at' => '2016-12-16 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'jjjjjj',
                'last_name' => 'hhhhhh',
                'dob' => Carbon::today()->subYears(11)->subDays(1),
                'created_at' => '2016-12-16 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'jjjj',
                'last_name' => 'hhhhhh',
                'dob' => Carbon::today()->subYears(11)->subDays(1),
                'created_at' => '2016-12-16 07:15:20',
            ]));
        Team::create([
            'name' => 'Cybermen',
            'school' => 'School 6',
            'email' => 'kbrown@sc6.edu',
            'phone' => '37012345678',
            'teacher_first_name' => 'Kevin',
            'teacher_last_name' => 'Brown',
            'sumo' => true,
            'obstacles' => false,
            'contest_id' => $currContest->id,
            'approved' => true,
            'created_at' => '2016-01-02 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Sam',
                'last_name' => 'Robinson',
                'dob' => Carbon::today()->subYears(9)->subDays(40),
                'created_at' => '2016-12-16 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'John',
                'last_name' => 'Brown',
                'dob' => Carbon::today()->subYears(9)->subDays(86),
                'created_at' => '2016-12-16 07:15:20',
            ]));
        Team::create([
            'name' => 'Robots.Pro',
            'email' => 'natt1@gmail.com',
            'phone' => '3708936676',
            'teacher_first_name' => 'Nathan',
            'teacher_last_name' => 'Wolf',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $currContest->id,
            'approved' => true,
            'created_at' => '2016-12-16 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Jim',
                'last_name' => 'Brown',
                'dob' => Carbon::today()->subYears(10)->subDays(15),
                'created_at' => '2016-12-16 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Ton',
                'last_name' => 'Green',
                'dob' => Carbon::today()->subYears(9)->subDays(40),
                'created_at' => '2016-12-16 07:15:20',
            ]));
        Team::create([
            'name' => 'Uber Robots',
            'school' => 'School 1',
            'email' => 'bob.smith123@gmail.com',
            'phone' => '37012345678',
            'teacher_first_name' => 'Bob',
            'teacher_last_name' => 'Smith',
            'sumo' => true,
            'obstacles' => true,
            'contest_id' => $currContest->id,
            'created_at' => '2016-12-16 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Carol',
                'last_name' => 'Johnson',
                'dob' => Carbon::today()->subYears(11)->subDays(51),
                'created_at' => '2016-12-16 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Sam',
                'last_name' => 'Smith',
                'dob' => Carbon::today()->subYears(11)->subDays(115),
                'created_at' => '2016-12-16 07:15:20',
            ]));
        Team::create([
            'name' => 'Terminators',
            'school' => 'School 6',
            'email' => 'smartin@sc6.edu',
            'phone' => '37012345678',
            'teacher_first_name' => 'Samuel',
            'teacher_last_name' => 'Martin',
            'sumo' => true,
            'obstacles' => false,
            'contest_id' => $currContest->id,
            'created_at' => '2016-12-16 07:15:20',
        ])
            ->addMember(TeamMember::create([
                'first_name' => 'Ben',
                'last_name' => 'Green',
                'dob' => Carbon::today()->subYears(11)->subDays(42),
                'created_at' => '2016-12-16 07:15:20',
            ]))
            ->addMember(TeamMember::create([
                'first_name' => 'Matthew',
                'last_name' => 'Taylor',
                'dob' => Carbon::today()->subYears(11)->subDays(205),
                'created_at' => '2016-12-16 07:15:20',
            ]));

        Contest::reguard();
        Team::reguard();
        TeamMember::reguard();
        Carbon::setTestNow();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('contests')->delete();
        DB::table('teams_team_members')->delete();
        DB::table('team_members')->delete();
        DB::table('teams')->delete();
    }
}
