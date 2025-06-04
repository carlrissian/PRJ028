<?php

namespace Distribution\Department\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\Department\Domain\DepartmentCriteria;
use Distribution\Department\Domain\DepartmentRepository;

class SelectListDepartmentQueryHandler
{
    /**
     * @var DepartmentRepository
     */
    private $departmentRepository;

    /**
     * SelectListDepartmentQueryHandler constructor.
     *
     * @param DepartmentRepository $departmentRepository
     */
    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @return SelectListDepartmentResponse
     */
    public function handle(): SelectListDepartmentResponse
    {
        $departmentCollection = $this->departmentRepository->getBy(new DepartmentCriteria())->getCollection();
        return new SelectListDepartmentResponse(Utils::createSelect($departmentCollection));
    }
}
