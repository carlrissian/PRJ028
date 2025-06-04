<?php
declare(strict_types=1);

namespace Distribution\AcrissType\Infrastructure;

use Closure;
use Distribution\AcrissType\Domain\AcrissType;
use Distribution\AcrissType\Domain\AcrissTypeCriteria;
use Distribution\AcrissType\Domain\AcrissTypeCollection;
use Distribution\AcrissType\Domain\AcrissTypeGetByResponse;
use Distribution\AcrissType\Domain\AcrissTypeRepository;
use Exception;
use Shared\Repository\RepositoryHelper;

class AcrissTypeRepositorySap extends RepositoryHelper implements AcrissTypeRepository
{
    private const PREFIX_FUNCTION_NAME = 'AcrissTypeList/AcrissTypeListRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(AcrissTypeCriteria $criteria): AcrissTypeGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $method = 'GET';
        $collection = new AcrissTypeCollection([]);
        try {
            $bodyArray = RepositoryHelper::createCriteria($criteria);
            $body = json_encode($bodyArray);
            $totalRows = $this->genericGetBy($method, $functionName, $body, 'TBasicAcrissTypeListResponse', $collection, Closure::fromCallable([$this, 'arrayToAcrissType']));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return (new AcrissTypeGetByResponse($collection, $totalRows));
    }

    /**
     * @throws Exception
     */
    final public function getById(int $id): AcrissType
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;
        $method = 'GET';
        try {
            $response = $this->sapRequestHelper->request($method, $functionName, '');
            if ($response === false) {
                throw new Exception('Something fail during query');
            }
            $responseArray = json_decode($response, true);
            if (!$responseArray || !isset($responseArray['TBasicAcrissTypeListResponse'])) {
                throw new Exception('Something fail during getById ');
            }
            $acrissTypeArray = $responseArray['TBasicAcrissTypeListResponse'][0];
            $acrissType = $this->arrayToAcrissType($acrissTypeArray);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return $acrissType;
    }
    final public function arrayToAcrissType(array $areaArray): AcrissType
    {
        return new AcrissType(
            intval($areaArray['ID']),
            $areaArray['CARTYPENAME']??null,
            $areaArray['ACRISS1LETTER']??null
        );
    }
}