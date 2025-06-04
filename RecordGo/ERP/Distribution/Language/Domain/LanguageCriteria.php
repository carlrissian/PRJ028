<?php
declare(strict_types=1);


namespace Distribution\Language\Domain;


use Shared\Domain\Criteria\Criteria;

class LanguageCriteria extends Criteria
{

    public function getAllowedFields(): array
    {
        return[
            'id',
            'name',
            'languageCode'
        ];
    }
}