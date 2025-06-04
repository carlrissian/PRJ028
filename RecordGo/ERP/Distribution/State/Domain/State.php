<?php

declare(strict_types=1);

namespace Distribution\State\Domain;

use Shared\Utils\DataValidation;

class State
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $iso;

    /**
     * @var int|null
     */
    private ?int $countryId;

    /**
     * State constructor.
     * @param int $id
     * @param string|null $name
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?string $iso = null,
        ?int $countryId = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->iso = $iso;
        $this->countryId = $countryId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getISO(): ?string
    {
        return $this->iso;
    }

    /**
     * @return int|null
     */
    public function getCountryId(): ?int
    {
        return $this->countryId;
    }


    /**
     * @param array|null $stateArray
     * @return self
     */
    public static function createFromArray(?array $stateArray): self
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($stateArray, 'ID')),
            $helper->arrayExistOrNull($stateArray, 'STATENAME'),
            $helper->arrayExistOrNull($stateArray, 'ISOCODE'),
            $helper->intOrNull($helper->arrayExistOrNull($stateArray, 'COUNTRYID'))
        );
    }

    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'STATENAME' => $this->getName(),
            'STATEISOCODE' => $this->getISO(),
            'COUNTRYID' => $this->getCountryId(),
        ];
    }
}
