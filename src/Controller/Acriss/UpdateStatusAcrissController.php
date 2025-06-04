<?php

declare(strict_types=1);

namespace App\Controller\Acriss;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\Acriss\Application\UpdateStatusAcriss\UpdateStatusAcrissCommand;
use Distribution\Acriss\Application\UpdateStatusAcriss\UpdateStatusAcrissCommandHandler;

class UpdateStatusAcrissController extends Controller
{
    /**
     * @var UpdateStatusAcrissCommandHandler
     */
    private UpdateStatusAcrissCommandHandler $handler;

    public function __construct(UpdateStatusAcrissCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * 
     * @throws InvalidAcrissException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $response = $this->handler->handle(new UpdateStatusAcrissCommand(
            intval($request->get('acrissId')),
            filter_var($request->get('status'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
        ));

        return $this->json([
            'updated' => $response->isUpdated(),
            'onBooking' => $response->isOnBooking(),
        ]);
    }
}
