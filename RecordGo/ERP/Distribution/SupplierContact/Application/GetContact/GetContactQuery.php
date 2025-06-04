<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Application\GetContact;


class GetContactQuery
{
    private ?string $code;

    /**
     * @param string|null $code
     */
    public function __construct(?string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    final public function getCode(): ?string
    {
        return $this->code;
    }

}