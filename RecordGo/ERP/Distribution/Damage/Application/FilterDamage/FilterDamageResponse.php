<?php

namespace Distribution\Damage\Application\FilterDamage;

class FilterDamageResponse
{
    /**
     * @var array
     */
    private $damageList;

    /**
     * FilterDamageResponse constructor.
     * 
     * @param array $damageList
     */
    public function __construct(array $damageList)
    {

        $this->damageList = $damageList;
    }

    /**
     * @return array
     */
    public function getDamageList(): array
    {
        return $this->damageList;
    }
}
