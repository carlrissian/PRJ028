<?php

namespace Distribution\StopSale\Domain;

final class Day
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
    private function __construct(int $id, ?string $name)
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
     * @param int $id
     * @param string|null $name
     */
    public static function create(int $id, ?string $name = null): self
    {
        return new self($id, $name);
    }

    /**
     * @param array|null $dayArray
     * @return self
     */
    public static function createFromArray(?array $dayArray): self
    {
        return self::create(
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
