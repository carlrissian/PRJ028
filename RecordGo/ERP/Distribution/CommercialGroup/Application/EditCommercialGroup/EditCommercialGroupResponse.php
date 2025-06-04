<?php
declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\EditCommercialGroup;


class EditCommercialGroupResponse
{

   /**
    * @var array
    */
   private array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

}
