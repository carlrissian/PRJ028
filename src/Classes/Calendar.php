<?php
declare(strict_types=1);


namespace App\Classes;


use DateTime;

class Calendar
{
    public function calendar(string $year): array
    {
        $calendar = [];
        setlocale(LC_ALL, 'es_ES.utf8');
        for ($i = 1; $i <13; $i++) {
            $dateInit = new DateTime("$year-$i-01");
            $dayMax = (int) $dateInit->format('t');
            $daysWeek = (int) $dateInit->format('w');
            $dateEnd = new DateTime("$year-$i-$dayMax");
            $daysWeek = $daysWeek === 0 ? 7 : $daysWeek;
            $weeks = $this->numWeeks($dateInit, $dateEnd);
            $dateObj = DateTime::createFromFormat('!m', $i);
            $monthName = strftime('%B', $dateObj->getTimestamp());
            $numMonth = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $calendar[] = ['daysWeek' => $daysWeek, 'dayMax' => $dayMax, 'weeks' => $weeks,
                'month' => ucwords ($monthName), 'year' => $year, 'numMonth' => $numMonth];
        }
        return $calendar;
    }

    private function numWeeks(DateTime $dateInit, DateTime $dateEnd): int
    {
        $weekInit = (int) $dateInit->format('n') === 1 ? 0 : $dateInit->format('W');
        $weekEnd = (int) $dateEnd->format('W');
        $weekEnd = $weekEnd === 1 ? (52 + 1): $weekEnd;
        $count = 0;
        while ($weekInit <= $weekEnd) {
            $weekInit++;
            $count++;
        }
        return $count;
    }
}