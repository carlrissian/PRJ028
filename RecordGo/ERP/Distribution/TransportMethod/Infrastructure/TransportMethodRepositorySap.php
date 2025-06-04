<?php
declare(strict_types=1);


namespace Distribution\TransportMethod\Infrastructure;



use Distribution\TransportMethod\Domain\TransportMethod;
use Distribution\TransportMethod\Domain\TransportMethodCollection;
use Distribution\TransportMethod\Domain\TransportMethodCriteria;
use Distribution\TransportMethod\Domain\TransportMethodGetByResponse;
use Distribution\TransportMethod\Domain\TransportMethodRepository;
use Shared\Domain\RequestHelper\SapRequestHelper;

class TransportMethodRepositorySap implements TransportMethodRepository
{

    private SapRequestHelper $sapRequestHelper;
    private const PREFIX_FUNCTION_NAME = 'TransportMethod/TransportMethodRepository';

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        $this->sapRequestHelper = $sapRequestHelper;
    }

    public function getBy(TransportMethodCriteria $criteria): TransportMethodGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        $method = 'GET';
        $collection = new TransportMethodCollection([]);

        $body = json_encode([]);

        $response = $this->sapRequestHelper->request($method, $functionName, $body);

        $response = json_decode($response, true);

        foreach ($response['TTransportMethodResponse'] as $purchaseTypeArray) {
            $collection->add(new TransportMethod(
                intval($purchaseTypeArray['ID']),
                $purchaseTypeArray['NAME']
            ));
        }

        return new TransportMethodGetByResponse($collection, $collection->count());
    }

}