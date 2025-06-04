<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

/**
 * Class MotorizationType
 * @package Distribution\Vehicle\Domain
 */
class MotorizationType
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
     * @param array|null $mototrizationTypeArray
     * @return self
     */
    public static function createFromArray(?array $mototrizationTypeArray): self
    {
        return new self(
            intval($mototrizationTypeArray['ID']),
            $mototrizationTypeArray['MOTORTYPENAME'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'MOTORTYPENAME' => $this->getName(),
        ];
    }
}
