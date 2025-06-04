<?php
declare(strict_types=1);


namespace Distribution\Language\Domain;


use Shared\Domain\Collection;

class LanguageCollection extends Collection
{
    protected function type(): string
    {
        return Language::class;
    }
}