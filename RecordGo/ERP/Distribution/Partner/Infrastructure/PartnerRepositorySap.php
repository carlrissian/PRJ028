<?php

declare(strict_types=1);

namespace Distribution\Partner\Infrastructure;

use Shared\Repository\RepositoryHelper;
use Distribution\Partner\Domain\Partner;
use Distribution\Partner\Domain\PartnerCriteria;
use Distribution\Partner\Domain\PartnerCollection;
use Distribution\Partner\Domain\PartnerRepository;
use Distribution\Partner\Domain\PartnerGetByResponse;

class PartnerRepositorySap extends RepositoryHelper implements PartnerRepository
{
    private const PREFIX_FUNCTION_NAME = 'Partners/PartnersRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(PartnerCriteria $criteria): PartnerGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new PartnerCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TPartnerResponse');

            foreach ($responseArray['TPartnerResponse'] as $itemArray) {
                $collection->add($this->arrayToPartner($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new PartnerGetByResponse($collection, $totalRows ?? 0);
    }


    /**
     * @param array $partnerArray
     * @return Partner
     */
    final private function arrayToPartner(array $partnerArray): Partner
    {
        return Partner::createFromArray($partnerArray);
    }
}
