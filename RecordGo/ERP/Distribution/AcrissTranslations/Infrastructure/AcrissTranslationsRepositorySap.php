<?php

declare(strict_types=1);

namespace Distribution\AcrissTranslations\Infrastructure;

use Exception;
use Shared\Repository\RepositoryHelper;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Distribution\AcrissTranslations\Domain\AcrissTranslation;
use Distribution\AcrissTranslations\Domain\AcrissTranslationsRepository;

class AcrissTranslationsRepositorySap extends RepositoryHelper implements AcrissTranslationsRepository
{
    private const PREFIX_FUNCTION_NAME = 'AcrissTranslations/AcrissTranslationsRepository';

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
    public function store(AcrissTranslation $acrissTranslation): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $body = json_encode($acrissTranslation->toArray());

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
    public function update(AcrissTranslation $acrissTranslation): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $acrissTranslation->getId();

        try {
            $body = json_encode($acrissTranslation->toArray());

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
    final public function arrayToAcrissTranslation(array $acrissTranslationArray): AcrissTranslation
    {
        return AcrissTranslation::createFromArray($acrissTranslationArray);
    }
}
