<?php

namespace App\Controller\TransportDriver;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Shared\Domain\ValueObject\DateValueObject;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\TransportDriver\Application\FilterTransportDriver\FilterTransportDriverQuery;
use Distribution\TransportDriver\Application\FilterTransportDriver\FilterTransportDriverQueyHandler;

class FilterController extends Controller
{
    /**
     * @var FilterTransportDriverQueyHandler
     */
    private $handler;

    /**
     * @param FilterTransportDriverQueyHandler $handler
     */
    public function __construct(FilterTransportDriverQueyHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query  = new FilterTransportDriverQuery(
            $request->get('sortBy'),
            $request->get('order'),
            $request->get('offset'),
            $request->get('limit'),
            $request->get('name') ? $request->get('name') : null,
            $request->get('lastName') ? $request->get('lastName') : null,
            $request->get('idNumber') ? $request->get('idNumber') : null,
            $request->get('driverLicense') ? $request->get('driverLicense') : null,
            $request->get('issueDate') ? DateValueObject::createFromString($request->get('issueDate')) : null,
            $request->get('expirationDate') ? DateValueObject::createFromString($request->get('expirationDate')) : null,
            $request->get('city') ? $request->get('city') : null,
            $request->get('countryId') ? $request->get('countryId') : null
        );

        $response = $this->handler->handle($query);

        return $this->json(!empty($response->getTransportDriverListResponse()) ? $response->getTransportDriverListResponse() : $this->json([], 404));
    }
}
