<?php
declare(strict_types=1);


namespace Distribution\PurchaseType\Infrastructure;


use Distribution\PurchaseType\Domain\PurchaseType;
use Distribution\PurchaseType\Domain\PurchaseTypeCollection;
use Distribution\PurchaseType\Domain\PurchaseTypeCriteria;
use Distribution\PurchaseType\Domain\PurchaseTypeGetByResponse;
use Distribution\PurchaseType\Domain\PurchaseTypeRepository;
use Doctrine\Common\Collections\Criteria;
use Shared\Domain\RequestHelper\SapRequestHelper;

class PurchaseTypeRepositorySap implements PurchaseTypeRepository
{

    private SapRequestHelper $sapRequestHelper;
    private const PREFIX_FUNCTION_NAME = 'PurchaseType/PurchaseTypeRepository';

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        $this->sapRequestHelper = $sapRequestHelper;
    }

    public function getBy(PurchaseTypeCriteria $criteria): PurchaseTypeGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        $method = 'GET';
        $collection = new PurchaseTypeCollection([]);

        $body = json_encode([]);

        $response = $this->sapRequestHelper->request($method, $functionName, $body);

        $response = json_decode($response, true);

        foreach ($response['TPurchaseTypeResponse'] as $purchaseTypeArray) {
            $collection->add(new PurchaseType(
                intval($purchaseTypeArray['ID']),
                $purchaseTypeArray['PURCHASETYPENAME']
            ));
        }

        return new PurchaseTypeGetByResponse($collection, $collection->count());
    }

}