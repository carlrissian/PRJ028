<?php

namespace Distribution\StopSale\Domain;

final class Partner
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
    private ?string $commercialName;

    /**
     * Partner constructor.
     * 
     * @param int $id
     * @param string|null $name
     * @param string|null $commercialName
     */
    private function __construct(int $id, ?string $name, ?string $commercialName)
    {
        $this->id = $id;
        $this->name = $name;
        $this->commercialName = $commercialName;
    }

    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    final public function getCommercialName(): ?string
    {
        return $this->commercialName;
    }


    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $commercialName
     */
    public static function create(
        int $id,
        ?string $name = null,
        ?string $commercialName = null
    ): self {
        return new self($id, $name, $commercialName);
    }

    /**
     * @param array|null $partnerArray
     * @return self
     */
    public static function createFromArray(?array $partnerArray): self
    {
        return self::create(
            intval($partnerArray['ID']),
            $partnerArray['NAMESOCIAL'] ?? null,
            $partnerArray['COMMERCIALNAME'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
        ];
    }
}
