<?php
declare(strict_types=1);


namespace Distribution\CarBodyType\Domain;


use Shared\Domain\Collection;

class CarBodyTypeCollection extends Collection
{

    protected function type(): string
    {
        return CarBodyType::class;
    }
}