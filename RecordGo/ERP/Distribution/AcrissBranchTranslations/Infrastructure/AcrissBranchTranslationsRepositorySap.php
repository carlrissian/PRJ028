<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Infrastructure;

use Closure;
use Exception;
use Shared\Repository\RepositoryHelper;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsCriteria;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationCollection;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepository;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsGetByResponse;

class AcrissBranchTranslationsRepositorySap extends RepositoryHelper implements AcrissBranchTranslationsRepository
{
    private const PREFIX_FUNCTION_NAME = 'AcrissBranchTranslations/AcrissBranchTranslationsRepository';

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
    public function getBy(AcrissBranchTranslationsCriteria $criteria): AcrissBranchTranslationsGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new AcrissBranchTranslationCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TAcrissBranchTranslationResponse', $collection, Closure::fromCallable([$this, 'arrayToAcrissBranchTranslation']));

            return (new AcrissBranchTranslationsGetByResponse($collection, $totalRows ?? 0));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function store(AcrissBranchTranslation $commercialGroup): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $body = json_encode($commercialGroup->toArray());

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
    public function update(AcrissBranchTranslation $commercialGroup): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $commercialGroup->getId();

        try {
            $body = json_encode($commercialGroup->toArray());

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
    final public function arrayToAcrissBranchTranslation(array $acrissBranchTranslationArray): AcrissBranchTranslation
    {
        return AcrissBranchTranslation::createFromArray($acrissBranchTranslationArray);
    }
}
