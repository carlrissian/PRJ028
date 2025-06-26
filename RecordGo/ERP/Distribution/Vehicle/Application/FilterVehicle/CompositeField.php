<?php

namespace Distribution\Vehicle\Application\FilterVehicle;

class CompositeField
{
    private string $field1;
    private string $operator;
    private string $field2;

    public function __construct(string $field1, string $operator, string $field2)
    {
        $this->field1 = $field1;
        $this->operator = $operator;
        $this->field2 = $field2;
    }

    public function __toString(): string
    {
        return "{$this->field1}_{$this->operator}_{$this->field2}";
    }

    public function getField1(): string
    {
        return $this->field1;
    }

    public function getField2(): string
    {
        return $this->field2;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }
}
