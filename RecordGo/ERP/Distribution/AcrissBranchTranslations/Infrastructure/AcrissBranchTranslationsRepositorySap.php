<?php

namespace Distribution\AcrissBranchTranslations\Infrastructure;

use Shared\Utils\Utils;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsCriteria;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationCollection;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsGetByResponse;
use Distribution\AcrissBranchTranslations\Domain\Exception\AcrissBranchTranslationException;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepositoryInterface;

class AcrissBranchTranslationsRepositorySap implements AcrissBranchTranslationsRepositoryInterface
{
    private const PREFIX_FUNCTION_NAME = 'AcrissBranchTranslations/AcrissBranchTranslationsRepository';

    /**
     * @var SapRequestHelper $sapRequestHelper
     */
    public SapRequestHelper $sapRequestHelper;

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        $this->sapRequestHelper = $sapRequestHelper;
    }

    /**
     * @inheritDoc
     */
    public function getBy(AcrissBranchTranslationsCriteria $criteria): AcrissBranchTranslationsGetByResponse
    {
        $functionName = sprintf('%s_%s', self::PREFIX_FUNCTION_NAME, __FUNCTION__);
        $collection = new AcrissBranchTranslationCollection([]);

        try {
            $body = json_encode(Utils::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);
            if (empty($response)) {
                throw new AcrissBranchTranslationException(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);

            foreach ($responseArray['TAcrissBranchTranslationResponse'] as $itemArray) {
                $collection->add($this->arrayToAcrissBranchTranslation($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();

            return new AcrissBranchTranslationsGetByResponse($collection, $totalRows ?? 0);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @inheritDoc
     */
    public function store(AcrissBranchTranslation $acrissBranchTranslation): int
    {
        $functionName = sprintf('%s_%s', self::PREFIX_FUNCTION_NAME, __FUNCTION__);

        try {
            $body = json_encode($acrissBranchTranslation->toArray());

            $response = $this->sapRequestHelper->request('POST', $functionName, $body);
            $responseArray = json_decode($response, true);

            return isset($responseArray['ID']) ? intval($responseArray['ID']) : null;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }




    /**
     * @inheritDoc
     */
    public function update(AcrissBranchTranslation $acrissBranchTranslation): int
    {
        $functionName = sprintf('%s_%s/%d', self::PREFIX_FUNCTION_NAME, __FUNCTION__, $acrissBranchTranslation->getId());

        try {
            $body = json_encode($acrissBranchTranslation->toArray());

            $response = $this->sapRequestHelper->request('PATCH', $functionName, $body);
            $responseArray = json_decode($response, true);

            return isset($responseArray['ID']) ? intval($responseArray['ID']) : null;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }





    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $functionName = sprintf('%s_%s/%d', self::PREFIX_FUNCTION_NAME, __FUNCTION__, $id);

        try {
            $response = $this->sapRequestHelper->request('DELETE', $functionName, "");
            $responseArray = json_decode($response, true);

            return $responseArray['SUCCESS'];
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
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
