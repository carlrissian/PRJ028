<?php
declare(strict_types=1);

namespace Distribution\GearBox\Infrastructure;

use Closure;
use Distribution\GearBox\Domain\GearBox;
use Distribution\GearBox\Domain\GearBoxCollection;
use Distribution\GearBox\Domain\GearBoxCriteria;
use Distribution\GearBox\Domain\GearBoxGetByResponse;
use Distribution\GearBox\Domain\GearBoxRepository;
use Exception;
use Shared\Repository\RepositoryHelper;

class GearBoxRepositorySap extends RepositoryHelper implements GearBoxRepository
{
    private const PREFIX_FUNCTION_NAME = 'GearBox/GearBoxRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(GearBoxCriteria $criteria): GearBoxGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $method = 'GET';
        $collection = new GearBoxCollection([]);
        try {
            $bodyArray = RepositoryHelper::createCriteria($criteria);
            $body = json_encode($bodyArray);
            $totalRows = $this->genericGetBy($method, $functionName, $body, 'TBasicGearBoxResponse', $collection, Closure::fromCallable([$this, 'arrayToGearBox']));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return (new GearBoxGetByResponse($collection, $totalRows));
    }

    /**
     * @throws Exception
     */
    final public function getById(int $id): GearBox
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;
        $method = 'GET';
        try {
            $response = $this->sapRequestHelper->request($method, $functionName, '');
            if ($response === false) {
                throw new Exception('Something fail during query');
            }
            $responseArray = json_decode($response, true);
            if (!$responseArray || !isset($responseArray['TBasicGearBoxResponse'])) {
                throw new Exception('Something fail during getById ');
            }
            $gearArray = $responseArray['TBasicGearBoxResponse'][0];
            $area = $this->arrayToGearBox($gearArray);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return $area;
    }
    final public function arrayToGearBox(array $areaArray): GearBox
    {
        return new GearBox(
            intval($areaArray['ID']),
            $areaArray['GEARBOXTYPE']??null,
            $areaArray['ACRISSTRANS']??null
        );
    }
}