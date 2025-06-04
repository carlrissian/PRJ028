<?php

namespace Distribution\Damage\Infrastructure;

use App\Constants\ErrorConstants;
use Distribution\Damage\Domain\Damage;
use Shared\Repository\RepositoryHelper;
use Distribution\Damage\Domain\DamageCriteria;
use Distribution\Damage\Domain\DamageException;
use Distribution\Damage\Domain\DamageCollection;
use Distribution\Damage\Domain\DamageRepository;
use Distribution\Damage\Domain\DamageGetByResponse;
use Distribution\Damage\Domain\DamageNotFoundException;

class DamageRepositorySap extends RepositoryHelper implements DamageRepository
{
    const PREFIX_FUNCTION_NAME = 'Damage/DamageRepository';

    /**
     * @param DamageCriteria $criteria
     * @return DamageGetByResponse
     * @throws DamageNotFoundException
     * @throws Exception
     */
    final public function getBy(DamageCriteria $criteria): DamageGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new DamageCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);
            $responseArray = json_decode($response, true);

            foreach ($responseArray['TDamageResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToDamage($itemArray));
                } catch (DamageNotFoundException $exception) {
                    throw new DamageNotFoundException($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new DamageGetByResponse($collection, $totalRows ?? 0);
    }


    /**
     * @throws Exception
     */
    final public function arrayToDamage(array $damageArray): Damage
    {
        return Damage::createFromArray($damageArray);
    }

    private function checkErrorCode(array $responseArray)
    {
        if (isset($responseArray['errorCode'])) {
            $code = is_numeric($responseArray['errorCode']) ? intval($responseArray['errorCode']) : 500;
            $message = $code == 500 ? ErrorConstants::CHECK_WITH_DEVELOP_MESSAGE : $responseArray['errorDescription'];
            throw new DamageException($message, $code);
        }
    }
}
