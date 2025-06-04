<?php

declare(strict_types=1);

namespace App\Controller\CommercialGroup;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Distribution\Shared\Domain\RepositoryException;
use Distribution\CommercialGroup\Application\StoreCommercialGroup\StoreCommercialGroupCommand;
use Distribution\CommercialGroup\Application\StoreCommercialGroup\StoreCommercialGroupCommandHandler;

class StoreCommercialGroupController extends Controller
{
    /**
     * @var StoreCommercialGroupCommandHandler
     */
    private StoreCommercialGroupCommandHandler $handler;

    /**
     * StoreCommercialGroupController constructor.
     *
     * @param StoreCommercialGroupCommandHandler $handler
     */
    public function __construct(StoreCommercialGroupCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return Response
     * 
     * @throws RepositoryException
     */
    public function __invoke(Request $request): Response
    {
        $commercialGroup = json_decode($request->get('commercialGroup'), true);

        $response = $this->handler->handle(new StoreCommercialGroupCommand(
            $commercialGroup['name'],
            $commercialGroup['acrissIds'],
            $commercialGroup['status']
        ));

        return $this->json([
            'created' => $response->isCreated(),
            'nameExists' => $response->nameExists(),
        ]);
    }
}
