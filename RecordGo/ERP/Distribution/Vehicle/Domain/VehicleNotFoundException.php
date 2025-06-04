<?php
declare(strict_types=1);


namespace Distribution\Vehicle\Domain;


use Exception;

class VehicleNotFoundException extends Exception
{
    private array $_data;

    public function __construct($message, $data)
    {
        $this->_data = $data;
        parent::__construct($message);
    }

    final public function getData(): array
    {
        return $this->_data;
    }
}