<?php

declare(strict_types=1);

namespace Distribution\Partner\Domain;

class Partner
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private string $name;

    /**
     * Partner constructor.
     * 
     * @param int $id
     * @param string|null $name
     */
    public function __construct(int $id, ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
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
     * @param array $partnerArray
     * @return self
     */
    public static function createFromArray(array $partnerArray): self
    {
        return new Partner(
            intval($partnerArray['ID']),
            $partnerArray['NAME'] ?? $partnerArray['NAMESOCIAL'] ?? null
        );
    }
}
