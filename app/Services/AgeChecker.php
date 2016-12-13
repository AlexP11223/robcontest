<?php


namespace App\Services;

use Carbon\Carbon;

class AgeChecker
{

    /**
     * Checks that the member is of eligible age (7-12)
     * @param Carbon $dob
     * @return bool
     */
    public static function isEligibleAge($dob)
    {
        return $dob->lt(Carbon::today()) &&
                $dob->age >= 7 && $dob->age <= 12;
    }
}
