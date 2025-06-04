<?php
declare(strict_types=1);


namespace Distribution\Model\Domain;


use Shared\Domain\Collection;

class ModelCollection extends Collection
{

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Model::class;
    }
}