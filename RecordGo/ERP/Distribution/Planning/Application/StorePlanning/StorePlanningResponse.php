<?php
declare(strict_types=1);


namespace Distribution\Planning\Application\StorePlanning;


class StorePlanningResponse
{
    /**
     * @var int
     */
    private int $id;

    /**
     * StorePlanningResponse constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}