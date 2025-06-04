<?php
declare(strict_types=1);


namespace Distribution\Day\Domain;


use Shared\Domain\Collection;

class DayCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return Day::class;
    }
}