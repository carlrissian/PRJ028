<?php

namespace Distribution\ParameterSetting\Domain;

final class Branch
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
     * Branch constructor
     *
     * @param integer $id
     * @param string|null $name
     */
    private function __construct(int $id, ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param integer $id
     * @param string|null $name
     */
    public static function create(
        int $id,
        ?string $name = null
    ): self {
        $branch = new self($id, $name);
        return $branch;
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
