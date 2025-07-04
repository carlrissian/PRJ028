<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\EditAcriss;


class EditAcrissResponse
{
    /**
     *@var array
     */
    private array $acriss;
    /**
     * @var array
     */
    private array $branchTranslations;
    /**
     * @var array
     */
    private $carClassList;
    /**
     * @var array
     */
    private $acrissTypeList;
    /**
     * @var array
     */
    private $gearBoxList;
    /**
     * @var array
     */
    private $motorizationList;
    /**
     * @var array
     */
    private $branchList;

    /**
     * @param array $acriss
     * @param array $branchTranslations
     * @param $carClassList
     * @param $acrissTypeList
     * @param $gearBoxList
     * @param $motorizationList
     * @param $branchList
     */
    public function __construct(array $acriss, array $branchTranslations, $carClassList, $acrissTypeList, $gearBoxList, $motorizationList, $branchList)
    {
        $this->acriss = $acriss;
        $this->branchTranslations = $branchTranslations;
        $this->carClassList = $carClassList;
        $this->acrissTypeList = $acrissTypeList;
        $this->gearBoxList = $gearBoxList;
        $this->motorizationList = $motorizationList;
        $this->branchList = $branchList;
    }


    /**
     * @return array
     */
    public function getAcriss(): array
    {
        return $this->acriss;
    }

    /**
     * @return array
     */
    public function getBranchTranslations(): array
    {
        return $this->branchTranslations;
    }

    /**
     * @return mixed
     */
    public function getCarClassList()
    {
        return $this->carClassList;
    }

    /**
     * @return mixed
     */
    public function getAcrissTypeList()
    {
        return $this->acrissTypeList;
    }

    /**
     * @return mixed
     */
    public function getGearBoxList()
    {
        return $this->gearBoxList;
    }

    /**
     * @return mixed
     */
    public function getMotorizationList()
    {
        return $this->motorizationList;
    }

    /**
     * @return mixed
     */
    public function getBranchList()
    {
        return $this->branchList;
    }

}