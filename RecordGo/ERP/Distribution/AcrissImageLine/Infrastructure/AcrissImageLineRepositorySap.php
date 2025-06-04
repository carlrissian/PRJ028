<?php

declare(strict_types=1);

namespace Distribution\AcrissImageLine\Infrastructure;

use Exception;
use Shared\Repository\RepositoryHelper;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Distribution\AcrissImageLine\Domain\AcrissImageLine;
use Distribution\AcrissImageLine\Domain\AcrissImageLineRepository;

class AcrissImageLineRepositorySap extends RepositoryHelper implements AcrissImageLineRepository
{
    private const PREFIX_FUNCTION_NAME = 'AcrissImageLine/AcrissImageLineRepository';

    /**
     * @inheritDoc
     */
    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function store(AcrissImageLine $acrissImageLine): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $body = json_encode($acrissImageLine->toArray());

            $response = $this->genericSave('POST', $functionName, $body);

            return $response;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function update(AcrissImageLine $acrissImageLine): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $acrissImageLine->getId();

        try {
            $body = json_encode($acrissImageLine->toArray());

            $response = $this->genericSave('PATCH', $functionName, $body);

            return $response;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response = $this->sapRequestHelper->request('DELETE', $functionName, "");
            $responseArray = json_decode($response, true);

            return $responseArray['SUCCESS'];
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @throws Exception
     */
    final public function arrayToAcrissImageLine(array $acrissImageLineArray): AcrissImageLine
    {
        return AcrissImageLine::createFromArray($acrissImageLineArray);
    }
}
