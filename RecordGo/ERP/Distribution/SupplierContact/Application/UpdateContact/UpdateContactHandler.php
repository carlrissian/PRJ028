<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Application\UpdateContact;


use Distribution\Shared\Domain\RepositoryException;
use Distribution\SupplierContact\Domain\SupplierContact;
use Distribution\SupplierContact\Domain\SupplierContactRepositoryInterface;

/**
 * Class UpdateContactHandler
 * @package Distribution\SupplierContact\Application\UpdateContact
 */
class UpdateContactHandler
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
     * @param UpdateContactCommand $command
     * @return UpdateContactResponse
     * @throws RepositoryException
     */
    public function handle(UpdateContactCommand $command): UpdateContactResponse
    {
        $contact = new SupplierContact($command->getId(), $command->getSupplierCode(), $command->getDepartment(), $command->getName(), $command->getMail(), $command->getPhone(),
            $command->getComment());
        $response = $this->contactRepository->update($contact);
        return new UpdateContactResponse();
    }
}