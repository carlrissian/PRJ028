<?php
declare(strict_types=1);


namespace Distribution\MotorizationType\Domain;


use Shared\Domain\Collection;

class MotorizationTypeCollection extends Collection
{

    protected function type(): string
    {
        return MotorizationType::class;
    }
}