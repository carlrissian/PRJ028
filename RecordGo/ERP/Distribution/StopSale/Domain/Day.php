<?php

declare(strict_types=1);

namespace Distribution\StopSale\Domain;

class Day
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
     * Day constructor.
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
     * @param array|null $dayArray
     * @return self
     */
    final public static function createFromArray(?array $dayArray): self
    {
        return new self(
            intval($dayArray['WEEKDAYID']),
            $dayArray['SCHEDULEWEEKDAYNAME'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'WEEKDAYID' => $this->getId(),
        ];
    }
}
