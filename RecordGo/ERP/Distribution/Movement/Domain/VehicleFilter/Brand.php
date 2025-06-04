<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\VehicleFilter;

class Brand
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
     * Brand constructor.
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
     * @param array|null $brandArray
     * @return Brand
     */
    public static function createFromArray(?array $brandArray): Brand
    {

        return new self(
            intval($brandArray['ID']),
           $brandArray['BRANDNAME']
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId()
        ];
    }
}
