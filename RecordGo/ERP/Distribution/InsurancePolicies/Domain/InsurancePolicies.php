<?php

namespace Distribution\InsurancePolicies\Domain;

use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateValueObject;

class InsurancePolicies
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var Provider|null
     */
    private ?Provider $policyCompany;

    /**
     * @var Provider|null
     */
    private ?Provider $policyBroker;

    /**
     * @var string|null
     */
    private ?string $policyNumber;

    /**
     * @var PolicyType|null
     */
    private ?PolicyType $policyType;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $activationDate;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $finishDate;

    /**
     * @var PolicyStatus
     */
    private PolicyStatus $policyStatus;


    /**
     * InsurancePolicies constructor.
     *
     * @param integer $id
     * @param Provider|null $policyCompany
     * @param Provider|null $policyBroker
     * @param string|null $policyNumber
     * @param PolicyType|null $policyType
     * @param DateValueObject|null $activationDate
     * @param DateValueObject|null $finishDate
     * @param PolicyStatus $policyStatus
     */
    public function __construct(
        int $id,
        ?Provider $policyCompany,
        ?Provider $policyBroker,
        ?string $policyNumber,
        ?PolicyType $policyType,
        ?DateValueObject $activationDate,
        ?DateValueObject $finishDate,
        PolicyStatus $policyStatus
    ) {
        $this->id = $id;
        $this->policyCompany = $policyCompany;
        $this->policyBroker = $policyBroker;
        $this->policyNumber = $policyNumber;
        $this->policyType = $policyType;
        $this->activationDate = $activationDate;
        $this->finishDate = $finishDate;
        $this->policyStatus = $policyStatus;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Provider|null
     */
    public function getPolicyCompany(): ?Provider
    {
        return $this->policyCompany;
    }

    /**
     * @return Provider|null
     */
    public function getPolicyBroker(): ?Provider
    {
        return $this->policyBroker;
    }

    /**
     * @return string|null
     */
    public function getPolicyNumber(): ?string
    {
        return $this->policyNumber;
    }

    /**
     * @return PolicyType|null
     */
    public function getPolicyType(): ?PolicyType
    {
        return $this->policyType;
    }

    /**
     * @return DateValueObject|null
     */
    public function getActivationDate(): ?DateValueObject
    {
        return $this->activationDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getFinishDate(): ?DateValueObject
    {
        return $this->finishDate;
    }

    /**
     * @return PolicyStatus
     */
    public function getPolicyStatus(): PolicyStatus
    {
        return $this->policyStatus;
    }


    /**
     * @param array $insurancePoliciesArray
     * @return self
     */
    public static function createFromArray(array $insurancePoliciesArray): self
    {
        return new self(
            intval($insurancePoliciesArray['ID']),
            isset($insurancePoliciesArray['PolicyCompany']) ? Provider::createFromArray($insurancePoliciesArray['PolicyCompany']) : null,
            isset($insurancePoliciesArray['PolicyBroker']) ? Provider::createFromArray($insurancePoliciesArray['PolicyBroker']) : null,
            $insurancePoliciesArray['POLICYNUM'] ?? null,
            isset($insurancePoliciesArray['PolicyType']) ? PolicyType::createFromArray($insurancePoliciesArray['PolicyType']) : null,
            $insurancePoliciesArray['ACTIVATIONDATE'] ? new DateValueObject(Utils::convertOdataDateToDateTime($insurancePoliciesArray['ACTIVATIONDATE'])) : null,
            $insurancePoliciesArray['FINISHDATE'] ? new DateValueObject(Utils::convertOdataDateToDateTime($insurancePoliciesArray['FINISHDATE'])) : null,
            isset($insurancePoliciesArray['PolicyStatus']) ? PolicyStatus::createFromArray($insurancePoliciesArray['PolicyStatus']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'POLICYNUM' => $this->getPolicyNumber(),
            'ACTIVATIONDATE' => $this->getActivationDate(),
            'FINISHDATE' => $this->getFinishDate(),
            'PolicyCompany' => $this->getPolicyCompany()->toArray(),
            'PolicyBroker' => $this->getPolicyBroker()->toArray(),
            'PolicyType' => $this->getPolicyType()->toArray(),
            'PolicyStatus' => $this->getPolicyStatus()->toArray()
        ];
    }
}
