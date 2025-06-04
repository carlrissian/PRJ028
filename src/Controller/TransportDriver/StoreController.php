<?php

declare(strict_types=1);

namespace App\Controller\TransportDriver;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\TransportDriver\Application\StoreTransportDriver\StoreTransportDriverCommand;
use Distribution\TransportDriver\Application\StoreTransportDriver\StoreTransportDriverCommandHandler;

class StoreController extends Controller
{
    /**
     * @var StoreTransportDriverCommandHandler
     */
    private $handler;

    /**
     * @param StoreTransportDriverCommandHandler $handler
     */
    public function __construct(StoreTransportDriverCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $driver = json_decode($request->get('driver'), true);

        $command = new StoreTransportDriverCommand(
            $driver['name'],
            $driver['lastName'],
            $driver['idNumber'],
            $driver['driverLicense'],
            $driver['issueDate'],
            $driver['expirationDate'],
            $driver['city'],
            intval($driver['state']['id']),
            $driver['state']['name'],
            intval($driver['country']['id']),
            $driver['country']['name'],
            intval($driver['postalCode']),
            $driver['address'],
            boolval($driver['internalDriver']),
            isset($driver['provider']['id']) ? intval($driver['provider']['id']) : null,
            intval($driver['branch']['id']),
            $driver['branch']['name']
        );

        $response = $this->handler->handle($command);

        return $this->json($response);
    }
}
