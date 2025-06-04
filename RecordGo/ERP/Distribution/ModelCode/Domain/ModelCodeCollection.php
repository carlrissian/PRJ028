<?php
declare(strict_types=1);

namespace Distribution\ModelCode\Domain;

use Shared\Domain\Collection;

class ModelCodeCollection extends Collection
{
    final protected function type(): string
    {
        return ModelCode::class;
    }
}