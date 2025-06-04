<?php
declare(strict_types=1);


namespace Distribution\AcrissType\Domain;


use Shared\Domain\Collection;

class AcrissTypeCollection extends Collection
{

    protected function type(): string
    {
        return AcrissType::class;
    }
}