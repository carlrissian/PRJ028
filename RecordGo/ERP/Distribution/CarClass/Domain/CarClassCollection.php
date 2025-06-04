<?php
declare(strict_types=1);


namespace Distribution\CarClass\Domain;


use Shared\Domain\Collection;

class CarClassCollection extends Collection
{

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return CarClass::class;
    }
}