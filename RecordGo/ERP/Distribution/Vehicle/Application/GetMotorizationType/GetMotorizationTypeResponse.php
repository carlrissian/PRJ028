<?php

namespace Distribution\Vehicle\Application\GetMotorizationType;

class GetMotorizationTypeResponse
{
    /**
     * @var array
     */
    private $motorizationType;

    /**
     * GetMotorizationTypeResponse constructor.
     *
     * @param array $motorizationType
     */
    public function __construct(array $motorizationType)
    {
        $this->motorizationType = $motorizationType;
    }

    /**
     * @return array
     */
    public function getMotorizationType(): array
    {
        return $this->motorizationType;
    }
}
