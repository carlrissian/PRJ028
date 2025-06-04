<?php
declare(strict_types=1);


namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Extensions extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('checkDateSame', [$this, 'checkDateSameFilter'])
        ];
    }

    public function checkDateSameFilter($date)
    {
        $d2 = date('d/m/yy');
        return $d2 === $date;
    }
}