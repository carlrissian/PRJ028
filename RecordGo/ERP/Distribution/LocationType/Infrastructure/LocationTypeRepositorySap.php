<?php
declare(strict_types=1);


namespace Distribution\LocationType\Infrastructure;


use Closure;
use Distribution\LocationType\Domain\LocationType;
use Distribution\LocationType\Domain\LocationTypeCollection;
use Distribution\LocationType\Domain\LocationTypeCriteria;
use Distribution\LocationType\Domain\LocationTypeGetByResponse;
use Distribution\LocationType\Domain\LocationTypeRepository;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Shared\Repository\RepositoryHelper;

class LocationTypeRepositorySap extends RepositoryHelper implements LocationTypeRepository
{
    private const PREFIX_FUNCTION_NAME = 'LocationType/LocationTypeRepository';


    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    public function getBy(LocationTypeCriteria $locationTypeCriteria): LocationTypeGetByResponse
    {
        $locationTypeCollection = new LocationTypeCollection([]);

        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $body = json_encode([]);

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TLocationTypeResponse', $locationTypeCollection, Closure::fromCallable([$this, 'arrayToLocationType']));

            return new LocationTypeGetByResponse($locationTypeCollection, $totalRows);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    private function arrayToLocationType(array $locationTypeArray): LocationType
    {
        return LocationType::createFromArray($locationTypeArray);
    }

}