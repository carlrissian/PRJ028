<?php
declare(strict_types=1);


namespace Distribution\BusinessUnitArticle\Domain;


use Shared\Domain\Enum;

class BusinessUnitArticleOptions extends Enum
{

    public const BUSINESS_UNIT_ARTICLE_TRANSPORT_BUYBACK      = '020205010001';//transportista buyback
    public const BUSINESS_UNIT_ARTICLE_TRANSPORT_SELL_B2B     = '020205010002';//transportista venta b2b
    public const BUSINESS_UNIT_ARTICLE_TRANSPORT_SELL_B2C     = '020205010004';//transportista venta b2c
    public const BUSINESS_UNIT_ARTICLE_TRANSPORT_DISTRIBUTION = '020205010003';//transportista distribución
    public const BUSINESS_UNIT_ARTICLE_TRANSPORT_IN_FLEET    = '020205010005';//transportista en flota

    public const BUSINESS_UNIT_ARTICLE_DRIVER_BUYBACK    = '020205020001';//transportista en flota
    public const BUSINESS_UNIT_ARTICLE_DRIVER_B2B    = '020205020002';//transportista en flota
    public const BUSINESS_UNIT_ARTICLE_DRIVER_B2C    = '020205020004';//transportista en flota
    public const BUSINESS_UNIT_ARTICLE_DRIVER_DISTRIBUTION    = '020205020003';//transportista en flota


    public const BUSINESS_UNIT_ARTICLE_MOVEMENT_AIRPORT_STATION   = '0603030010014';//moviemiento aeropuerto-estación (solo conductor y operaciones)


    protected function throwExceptionForInvalidValue($value)
    {
        // TODO: Implement throwExceptionForInvalidValue() method.
    }
}