<?php

declare(strict_types=1);

namespace Distribution\Location\Infrastructure;

use Exception;
use Shared\Repository\RepositoryHelper;
use Distribution\Location\Domain\Location;
use Distribution\Location\Domain\LocationCriteria;
use Distribution\Location\Domain\LocationCollection;
use Distribution\Location\Domain\LocationRepository;
use Distribution\Location\Domain\LocationGetByResponse;

class LocationRepositorySap extends RepositoryHelper implements LocationRepository
{
    private const PREFIX_FUNCTION_NAME = 'Location/LocationRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(LocationCriteria $criteria): LocationGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new LocationCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new Exception("The getBy request hasn't returned a response");
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TLocationResponse');

            foreach ($responseArray['TLocationResponse'] as $itemArray) {
                $collection->add($this->arrayToLocation($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return new LocationGetByResponse($collection, $totalRows);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getById(int $id): ?Location
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, '');
            $responseArray = json_decode($response, true);

            return count($responseArray['TLocationResponse']) > 0 ? $this->arrayToLocation($responseArray['TLocationResponse'][0]) : null;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @param array $locationArray
     * @return Location
     */
    final public function arrayToLocation(array $locationArray): Location
    {
        return Location::createFromArray($locationArray);
    }
}
