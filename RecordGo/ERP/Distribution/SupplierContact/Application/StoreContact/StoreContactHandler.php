<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Application\StoreContact;


use Distribution\Shared\Domain\RepositoryException;
use Distribution\SupplierContact\Domain\SupplierContact;
use Distribution\SupplierContact\Domain\SupplierContactRepositoryInterface;

/**
 * Class StoreContactHandler
 * @package Distribution\SupplierContact\Application\StoreContact
 */
class StoreContactHandler
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
     * @param StoreContactCommand $command
     * @return StoreContactResponse
     * @throws RepositoryException
     */
    public function handle(StoreContactCommand $command): StoreContactResponse
    {
        $contact = new SupplierContact(null,  $command->getCode(), $command->getDepartment(), $command->getName(), $command->getMail(), $command->getPhone(),
            $command->getComment());
        $response = $this->contactRepository->store($contact);
        return new StoreContactResponse();
    }
}