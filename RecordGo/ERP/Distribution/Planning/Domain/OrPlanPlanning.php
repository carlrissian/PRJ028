<?php
declare(strict_types=1);


namespace Distribution\Planning\Domain;


class OrPlanPlanning
{

    /**
     * @var DelegationCollection|null
     */
    private ?DelegationCollection $delegationCollection;

    /**
     * OrPlanPlanning constructor.
     * @param DelegationCollection|null $delegationCollection
     */
    public function __construct(?DelegationCollection $delegationCollection)
    {
        $this->delegationCollection = $delegationCollection;
    }

    /**
     * @return DelegationCollection|null
     */
    public function getDelegationCollection(): ?DelegationCollection
    {
        return $this->delegationCollection;
    }


}