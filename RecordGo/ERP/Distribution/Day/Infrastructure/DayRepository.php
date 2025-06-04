<?php

namespace Distribution\Day\Infrastructure;

use Distribution\Day\Domain\Day;
use Shared\Repository\RepositoryHelper;

class DayRepository extends RepositoryHelper
{
    final public function arrayListToArrayDay(array $dayList): array
    {
        $branches = [];
        if (count($dayList)>0){
            for ($i = 0; $i < count($dayList); $i++){
                $branches[] = $this->arrayToDay($dayList[$i]);
            }
        }
        return $branches;
    }
    final public function arrayToDay(array $dayArray): Day
    {
        return new Day($dayArray['ID']??null, $dayArray['WEEKDAYID']);
    }
}