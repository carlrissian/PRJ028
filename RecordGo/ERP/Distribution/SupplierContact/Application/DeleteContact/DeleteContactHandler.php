<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Application\DeleteContact;


use Distribution\Shared\Domain\RepositoryException;
use Distribution\SupplierContact\Domain\SupplierContactRepositoryInterface;

/**
 * Class DeleteContactHandler
 * @package Distribution\SupplierContact\Application\DeleteContact
 */
class DeleteContactHandler
{

    /**
     * @var SupplierContactRepositoryInterface
     */
    private SupplierContactRepositoryInterface $contactRepository;

    /**
     * StoreContactHandler constructor.
     * @param SupplierContactRepositoryInterface $contactRepository
     */
    public function __construct(SupplierContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param DeleteContactQuery $query
     * @return DeleteContactResponse
     * @throws RepositoryException
     */
    public function handle(DeleteContactQuery $query): DeleteContactResponse
    {

        $response = $this->contactRepository->delete($query->getId());
        return new DeleteContactResponse();
    }
}