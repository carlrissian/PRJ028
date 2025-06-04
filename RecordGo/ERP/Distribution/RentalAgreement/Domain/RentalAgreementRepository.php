<?php

namespace Distribution\RentalAgreement\Domain;

use Distribution\RentalAgreement\Domain\ListLite\RentalAgreementListLiteGetByResponse;

/**
 * Interface RentalAgreementRepository
 * @package Distribution\RentalAgreement\Domain
 */
interface RentalAgreementRepository
{
    /**
     * @param RentalAgreementCriteria $rentalContractCriteria
     * @return RentalAgreementGetByResponse
     */
    // public function getBy(RentalAgreementCriteria $rentalContractCriteria): RentalAgreementGetByResponse;

    /**
     * @param RentalAgreementCriteria $rentalAgreementCriteria
     * @return RentalAgreementListLiteGetByResponse
     */
    // public function getByLite(RentalAgreementCriteria $rentalAgreementCriteria): RentalAgreementListLiteGetByResponse;

    /**
     * @param integer $vehicleId
     * @return RentalAgreementListLiteGetByResponse
     */
    public function getByVehicle(int $vehicleId): RentalAgreementListLiteGetByResponse;

    /**
     * @param int $id
     * @return RentalAgreement
     */
    // public function getById(int $id): RentalAgreement;

    /**
     * @param RentalAgreementRequest $rentalAgreementRequest
     * @return integer
     */
    // public function store(RentalAgreementRequest $rentalAgreementRequest): int;
    /**
     * @param RentalAgreementRequest $rentalAgreement
     * @return integer
     */
    // public function storeManual(RentalAgreementRequest $rentalAgreement): int;

    /**
     * @param RentalAgreement $rentalAgreement
     * @return int
     */
    // public function update(RentalAgreementRequest $rentalAgreement): int;

    /**
     * @param integer $rentalAgreementId
     * @param string $fileBase64
     * @return string
     */
    // public function uploadContract(int $rentalAgreementId, string $fileBase64): string;

    /**
     * @param AssignAcrissRequest $assignAcrissRequest
     * @return integer
     */
    // public function assingAccriss(AssignAcrissRequest $assignAcrissRequest): int;

    /**
     * @param AssignBillingToRequest $assignBillingToRequest
     * @return integer
     */
    // public function assignBillingTo(AssignBillingToRequest $assignBillingToRequest): int;


    // Firmas

    /**
     * @param SignRentalAgreementRequest $signRentalAgreementRequest
     * @return boolean
     */
    // public function signRentalAgreement(SignRentalAgreementRequest $signRentalAgreementRequest): bool;

    /**
     * @param SignTTCCRequest $signTTCCRequest
     * @return boolean
     */
    // public function signTTCC(SignTTCCRequest $signTTCCRequest): bool;

    /**
     * @param integer $id
     * @return RaStatusLog
     */
    // public function getLastStatusLogById(int $id): RaStatusLog;

    /**
     * @param integer $id
     * @param integer $statusId
     * @return boolean
     */
    // public function updateStatus(int $id, int $statusId): bool;

    /**
     * @param integer $rentalAgreementId
     * @param integer $kmsPolicyLimit
     * @return integer
     */
    // public function updateKmsPolicyLimit(int $rentalAgreementId, int $kmsPolicyLimit): int;

    /**
     * @param CheckoutRequest $checkoutRequest
     * @return boolean
     */
    // public function checkout(CheckoutRequest $checkoutRequest): bool;
}
