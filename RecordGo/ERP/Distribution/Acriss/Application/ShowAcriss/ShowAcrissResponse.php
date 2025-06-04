<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\ShowAcriss;


class ShowAcrissResponse
{
    /**
     * @var array
     */
    private $acriss;

    /**
     * @param $acriss
     */
    public function __construct($acriss)
    {
        $this->acriss = $acriss;
    }

    /**
     * @return mixed
     */
    public function getAcriss()
    {
        return $this->acriss;
    }


}