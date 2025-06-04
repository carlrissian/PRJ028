<?php
declare(strict_types=1);


namespace Distribution\Trim\Application\GetTrim;

class GetTrimResponse
{
    /**
     * @var array
     */
    private array $trimList;

    /**
     * GetTrimResponse constructor.
     * @param array $trimList
     */
    public function __construct(array $trimList)
    {
        $this->trimList = $trimList;
    }

    /**
     * @return array
     */
    public function getTrimList(): array
    {
        return $this->trimList;
    }

}