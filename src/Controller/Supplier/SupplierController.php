<?php

declare(strict_types=1);

namespace App\Controller\Supplier;

use Exception;
use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\Shared\Domain\RepositoryException;
use Distribution\SupplierContact\Application\GetContact\GetContactQuery;
use Distribution\Supplier\Application\FilterSupplier\FilterSupplierQuery;
use Distribution\State\Application\FilterState\FilterStateQuery;
use Distribution\State\Application\FilterState\FilterStateQueryHandler;
use Distribution\SupplierContact\Application\GetContact\GetContactHandler;
use Distribution\SupplierContact\Application\DeleteContact\DeleteContactQuery;
use Distribution\SupplierContact\Application\StoreContact\StoreContactCommand;
use Distribution\SupplierContact\Application\StoreContact\StoreContactHandler;
use Distribution\Supplier\Application\FilterSupplier\FilterSupplierQueryHandler;
use Distribution\SupplierContact\Application\DeleteContact\DeleteContactHandler;
use Distribution\SupplierContact\Application\UpdateContact\UpdateContactCommand;
use Distribution\SupplierContact\Application\UpdateContact\UpdateContactHandler;

class SupplierController extends Controller
{
    final public function index(): Response
    {
        return $this->render('pages/supplier/index.html.twig');
    }

    /**
     * @throws Exception
     */
    final public function filter(Request $request, FilterSupplierQueryHandler $handler): JsonResponse
    {
        $query = new FilterSupplierQuery(
            $request->get('sort'),
            $request->get('order'),
            intval($request->get('offset')),
            intval($request->get('limit')),
            intval($request->get('id')),
            $request->get('name'),
            $request->get('vatNumber'),
            $request->get('city'),
            intval($request->get('province'))
        );

        $response = $handler->handle($query);

        return $this->json([
            'total' => $response->getTotalRows(),
            'rows' => $response->getCollection()
        ]);
    }

    final public function getSelector(FilterStateQueryHandler $handler): JsonResponse
    {
        $response = $handler->handle(new FilterStateQuery());

        return $this->json([
            'provinces' => $response->getStateList()
        ]);
    }

    public function getContacts(Request $request, GetContactHandler $getContactHandler): JsonResponse
    {
        $query = new GetContactQuery($request->get('code'));
        $response = $getContactHandler->handle($query);

        return $this->json([
            'total' => $response->getTotalRows(),
            'rows' => $response->getCollection()
        ]);
    }

    public function storeContact(Request $request, StoreContactHandler  $storeContactHandler): JsonResponse
    {
        $query = json_decode($request->getContent());
        $command = new StoreContactCommand(
            $query->code,
            $query->department,
            $query->name,
            $query->mail,
            $query->phone,
            $query->comment
        );
        try {
            $response = $storeContactHandler->handle($command);
        } catch (RepositoryException $e) {
            return $this->json(['success' => false]);
        }

        return $this->json(['success' => true]);
    }

    public function updateContact(Request $request, UpdateContactHandler $updateContactHandler): JsonResponse
    {
        $query = json_decode($request->getContent());
        $command = new UpdateContactCommand(
            $query->id,
            (string)$query->code,
            $query->department,
            $query->name,
            $query->mail,
            $query->phone,
            $query->comment
        );
        try {
            $response = $updateContactHandler->handle($command);
        } catch (RepositoryException $e) {
            return $this->json(['success' => false]);
        }

        return $this->json(['success' => true]);
    }

    public function deleteContact(Request $request, DeleteContactHandler $deleteContactHandler): JsonResponse
    {
        $query = json_decode($request->getContent());
        $command = new DeleteContactQuery((int)$query->id);
        try {
            $response = $deleteContactHandler->handle($command);
        } catch (RepositoryException $e) {
            return $this->json(['success' => false]);
        }

        return $this->json(['success' => true]);
    }
}
