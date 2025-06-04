<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

/**
 * Class Country
 * @package Distribution\Vehicle\Domain
 */
class Country
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @param int $id
     * @param string|null $name
     */
    public function __construct(
        int $id,
        ?string $name = null
    ) {
        $this->id = $id;
        $this->name = $name;
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
     * @param array|null $countryArray
     * @return self
     */
    public static function createFromArray(?array $countryArray): self
    {
        return new self(
            intval($countryArray['ID']),
            $countryArray['COUNTRYDESCRIPTION'] ?? null
        );
    }
    
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'COUNTRYDESCRIPTION' => $this->getName(),
        ];
    }
}
