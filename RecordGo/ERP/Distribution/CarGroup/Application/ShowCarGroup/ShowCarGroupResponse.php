<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Application\ShowCarGroup;


class ShowCarGroupResponse
{
    /**
     * @var array
     */
    private $carGroup;

    /**
     * @param $carGroup
     */
    public function __construct($carGroup)
    {
        $this->carGroup = $carGroup;
    }

    /**
     * @return mixed
     */
    public function getCarGroup()
    {
        return $this->carGroup;
    }


}