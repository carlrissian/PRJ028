<?php
declare(strict_types=1);


namespace Distribution\Trim\Infrastructure;

use Closure;
use Distribution\Trim\Domain\Trim;
use Distribution\Trim\Domain\TrimCollection;
use Distribution\Trim\Domain\TrimCriteria;
use Distribution\Trim\Domain\TrimGetByResponse;
use Distribution\Trim\Domain\TrimRepository;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Shared\Repository\RepositoryHelper;
use Shared\Utils\Utils;

class TrimRepositorySap extends RepositoryHelper implements TrimRepository
{
    private const PREFIX_FUNCTION_NAME = 'Trim/TrimRepository';

    /**
     * @inheritDoc
     */
    public function getBy(TrimCriteria $criteria): TrimGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $method = 'GET';
        $collection = new TrimCollection([]);
        try {
            $bodyArray = Utils::createCriteria($criteria);
            $body = json_encode($bodyArray);
            $totalRows = $this->genericGetBy($method, $functionName, $body, 'TTrimResponse', $collection, Closure::fromCallable([$this, 'arrayToTrim']));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return new TrimGetByResponse($collection, $totalRows ?? 0);
    }

    public function getById(int $id): Trim
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $trimArray = $this->genericGetById('GET', $functionName, 'TTrimResponse');

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return $this->arrayToTrim($trimArray);
    }

    final public function arrayToTrim(array $arrayType): Trim
    {
        return new Trim(intval($arrayType['ID']), $arrayType['TRIMNAME']);
    }
}