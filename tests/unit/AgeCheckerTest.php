<?php

use App\Services\AgeChecker;
use Carbon\Carbon;

class AgeCheckerTest extends TestCase
{
    public static function dateOfBirths()
    {
        return array(
            array(Carbon::now()->subYears(8), true),
            array(Carbon::now()->subYears(11), true),
            array(Carbon::now()->subYears(12), true),
            array(Carbon::now()->subYears(12)->subDays(100), true),
            array(Carbon::now()->subYears(7), true),
            array(Carbon::now()->subYears(7)->addDay(), false),
            array(Carbon::now()->subYears(13), false),
            array(Carbon::now(), false),
            array(Carbon::now()->addYears(1), false),
            array(Carbon::now()->addYears(8), false),
        );
    }

    /** @test
     * @dataProvider dateOfBirths
     */
    public function checks_eligible_age($dob, $isEligible)
    {
        $this->assertEquals($isEligible, AgeChecker::isEligibleAge($dob), $dob->toDateString());
    }
}
