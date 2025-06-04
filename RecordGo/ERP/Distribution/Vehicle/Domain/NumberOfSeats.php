<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

/**
 * Class Trim
 * @package Distribution\Vehicle\Domain
 */
class NumberOfSeats
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int|null
     */
    private ?int $value;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @param int $id
     * @param int|null $value
     * @param string|null $description
     */
    public function __construct(
        int $id,
        ?int $value = null,
        ?string $description = null
    ) {
        $this->id = $id;
        $this->value = $value;
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


    /**
     * @param array|null $numberOfSeatsArray
     * @return self
     */
    public static function createFromArray(?array $numberOfSeatsArray): self
    {
        return new self(
            intval($numberOfSeatsArray['ID']),
            isset($numberOfSeatsArray['CARSEATSVALUE']) ? intval($numberOfSeatsArray['CARSEATSVALUE']) : null,
            $numberOfSeatsArray['CARSEATSDESCRIPTION'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'CARSEATSVALUE' => $this->getValue(),
            'CARSEATSDESCRIPTION' => $this->getDescription(),
        ];
    }
}
