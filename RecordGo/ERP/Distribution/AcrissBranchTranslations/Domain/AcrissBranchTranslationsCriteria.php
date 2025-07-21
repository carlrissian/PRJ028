<?php

namespace Distribution\AcrissBranchTranslations\Domain;

use Shared\Domain\Criteria\Criteria;

final class AcrissBranchTranslationsCriteria extends Criteria
{
    /**
     * Devuelve un array con el conjunto de campos por los que se pueden hacer consultas al API
     * 
     * @return array
     */
    public function getAllowedFields(): array
    {
        return [
            'id',
            'acrissId',
            'branchId'
        ];
    }
}
