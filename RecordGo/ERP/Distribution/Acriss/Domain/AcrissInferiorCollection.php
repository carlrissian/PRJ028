<?php
declare(strict_types=1);


namespace Distribution\Acriss\Domain;


use Shared\Domain\Collection;

class AcrissInferiorCollection extends Collection
{

    protected function type(): string
    {
        return AcrissInferior::class;
    }
}