<?php
declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\CreateCommercialGroup;

class CreateCommercialGroupResponse
{

    /**
     * @var array
     */
    private array $acrissList;

    /**
     * @param array $acrissList
     */
    public function __construct(array $acrissList)
    {
        $this->acrissList = $acrissList;
    }

    /**
     * @return array
     */
    public function getAcrissList(): array
    {
        return $this->acrissList;
    }



}
