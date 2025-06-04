<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Domain;

use Shared\Utils\DataValidation;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Shared\Utils\Utils;

class CommercialGroup
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var AcrissCollection
     */
    private AcrissCollection $acriss;

    /**
     * @var TranslationCollection|null
     */
    private ?TranslationCollection $translations;

    /**
     * @var bool|null
     */
    private ?bool $active;

    /**
     * @var User|null
     */
    private ?User $creationUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;

    /**
     * @var User|null
     */
    private ?User $editionUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $editionDate;

    /**
     * @param int|null $id
     * @param string $name
     * @param AcrissCollection $acriss
     * @param TranslationCollection|null $translations
     * @param bool|null $active
     * @param User|null $creationUser
     * @param DateTimeValueObject|null $creationDate
     * @param User|null $editionUser
     * @param DateTimeValueObject|null $editionDate
     */
    public function __construct(
        ?int $id,
        string $name,
        AcrissCollection $acriss,
        ?TranslationCollection $translations = null,
        ?bool $active = null,
        ?User $creationUser = null,
        ?DateTimeValueObject $creationDate = null,
        ?User $editionUser = null,
        ?DateTimeValueObject $editionDate = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->acriss = $acriss;
        $this->translations = $translations;
        $this->active = $active;
        $this->creationUser = $creationUser;
        $this->creationDate = $creationDate;
        $this->editionUser = $editionUser;
        $this->editionDate = $editionDate;
    }

    /**
     * Get the value of id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of acriss
     *
     * @return AcrissCollection
     */
    public function getAcriss(): AcrissCollection
    {
        return $this->acriss;
    }

    /**
     * Set the value of acriss
     *
     * @param AcrissCollection  $acriss
     */
    public function setAcriss(AcrissCollection $acriss)
    {
        $this->acriss = $acriss;
    }

    /**
     * @return string|null
     */
    final public function getAcrissName(): ?string
    {
        $acrissName = '';

        if ($this->getAcriss()->count() > 0) {
            foreach ($this->getAcriss() as $acriss) {
                $acrissName .= $acriss->getName() . ', ';
            }
            $acrissName = substr($acrissName, 0, -2);
        }

        return $acrissName;
    }

    /**
     * Get the value of translations
     *
     * @return TranslationCollection|null
     */
    public function getTranslations(): ?TranslationCollection
    {
        return $this->translations;
    }

    /**
     * Set the value of translations
     *
     * @param TranslationCollection|null  $translations
     */
    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }

    /**
     * Get the value of active
     *
     * @return bool|null
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @param bool|null  $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get the value of creationUser
     *
     * @return User|null
     */
    public function getCreationUser(): ?User
    {
        return $this->creationUser;
    }

    /**
     * Get the value of creationDate
     *
     * @return DateTimeValueObject|null
     */
    public function getCreationDate(): ?DateTimeValueObject
    {
        return $this->creationDate;
    }

    /**
     * Get the value of editionUser
     *
     * @return User|null
     */
    public function getEditionUser(): ?User
    {
        return $this->editionUser;
    }

    /**
     * Get the value of editionDate
     *
     * @return DateTimeValueObject|null
     */
    public function getEditionDate(): ?DateTimeValueObject
    {
        return $this->editionDate;
    }


    /**
     * @param array|null $commercialGroupArray
     * @return CommercialGroup|null
     */
    public static function createFromArray(?array $commercialGroupArray): ?CommercialGroup
    {
        $helper = new DataValidation();

        $acrissCollection = new AcrissCollection([]);
        if (isset($commercialGroupArray['ACRISSARRAY'])) {
            foreach ($commercialGroupArray['ACRISSARRAY'] as $acriss) {
                $acrissCollection->add(Acriss::createFromArray($acriss));
            }
        }

        $traslationsCollection = new TranslationCollection([]);
        if (isset($commercialGroupArray['TRANSLATIONS'])) {
            foreach ($commercialGroupArray['TRANSLATIONS'] as $translation) {
                $traslationsCollection->add(Translation::createFromArray($translation));
            }
        }


        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($commercialGroupArray, 'ID')),
            $helper->arrayExistOrNull($commercialGroupArray, 'GROUPNAME'),
            $acrissCollection,
            $traslationsCollection,
            $helper->boolOrNull($helper->arrayExistOrNull($commercialGroupArray, 'ACTIVE')),
            (isset($commercialGroupArray['CREATIONUSER'])) ? User::createFromArray($commercialGroupArray['CREATIONUSER']) : null,
            (isset($commercialGroupArray['CREATIONDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($commercialGroupArray['CREATIONDATE'])) : null,
            (isset($commercialGroupArray['EDITIONUSER'])) ? User::createFromArray($commercialGroupArray['EDITIONUSER']) : null,
            (isset($commercialGroupArray['EDITIONDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($commercialGroupArray['EDITIONDATE'])) : null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $acrissArray = [];
        if (!empty($this->getAcriss())) {
            /**
             * @var Acriss $acriss
             */
            foreach ($this->getAcriss() as $acriss) {
                $acrissArray[] = $acriss->toArray();
            }
        }

        $translationsArray = [];
        if (!empty($this->getTranslations())) {
            /**
             * @var Translation $translation
             */
            foreach ($this->getTranslations() as $translation) {
                $translationsArray[] = $translation->toArray();
            }
        }

        return [
            'ID' => $this->getId(),
            'GROUPNAME' => $this->getName(),
            'ACRISSARRAY' => $acrissArray,
            'TRANSLATIONS' => $translationsArray,
            'ACTIVE' => filter_var($this->isActive(),FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ? 1 : 0,
            'CREATIONUSERID' => ($this->getCreationUser()) ? $this->getCreationUser()->getId() : null,
            'CREATIONDATE' => $this->getCreationDate() ? Utils::formatStringDateTimeToOdataDate($this->getCreationDate()->__toString(), 'd/m/Y H:i:s') : null,
            'EDITIONUSERID' => ($this->getEditionUser()) ? $this->getEditionUser()->getId() : null,
            'EDITIONDATE' => $this->getEditionDate() ? Utils::formatStringDateTimeToOdataDate($this->getEditionDate()->__toString(), 'd/m/Y H:i:s') : null,
        ];
    }
}
