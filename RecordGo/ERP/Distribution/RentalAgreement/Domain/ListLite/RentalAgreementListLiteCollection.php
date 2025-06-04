<?php

namespace Distribution\RentalAgreement\Domain\ListLite;

use Shared\Domain\Collection;

/**
 * @method RentalAgreementListLite getIterator()
 */
final class RentalAgreementListLiteCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return RentalAgreementListLite::class;
    }
}
