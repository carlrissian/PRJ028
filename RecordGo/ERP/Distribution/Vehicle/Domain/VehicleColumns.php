<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

abstract class VehicleColumns
{
    private static array $columns = [
        [
            'id' => 'licensePlate',
            'name' => 'Matrícula',
            'selected' => true,
            'disabled' => true,
            'sort' => "LICENSEPLATE",
        ],
        [
            'id' => 'vin',
            'name' => 'Bastidor',
            'selected' => true,
            'disabled' => true,
            'sort' => "VIN",
        ],
        [
            'id' => 'brand',
            'name' => 'Marca',
            'selected' => true,
            'disabled' => true,
            'sort' => "BRANDNAME",
        ],
        [
            'id' => 'model',
            'name' => 'Modelo',
            'selected' => true,
            'disabled' => true,
            'sort' => "MODELNAME",
        ],
        [
            'id' => 'trim',
            'name' => 'Acabado',
            'sort' => "TRIMNAME",
        ],
        [
            'id' => 'acriss',
            'name' => 'Acriss',
            'sort' => "ACRISSCODE",
        ],
        [
            'id' => 'carGroup',
            'name' => 'Grupo',
            'sort' => "VEHICLEGROUPNAME",
        ],
        [
            'id' => 'carClass',
            'name' => 'CarClass',
            'sort' => "CARCLASSNAME",
        ],
        [
            'id' => 'commercialGroup',
            'name' => 'Grupo comercial',
            'sort' => "GROUPNAME",
        ],
        [
            'id' => 'region',
            'name' => 'Región',
            'sort' => "REGIONNAME",
        ],
        [
            'id' => 'area',
            'name' => 'Area',
            'sort' => "AREANAME",
        ],
        [
            'id' => 'branch',
            'name' => 'Delegación',
            'sort' => "BRANCHINTNAME",
        ],
        [
            'id' => 'location',
            'name' => 'Localización',
            'sort' => "LOCATIONNAME",
        ],
        [
            'id' => 'vehicleStatus',
            'name' => 'Estado',
            'sort' => "STATUSNAME",
        ],
        [
            'id' => 'kilometers',
            'name' => 'Kilómetros',
            'sort' => "ACTUALKMS",
        ],
        [
            'id' => 'provider',
            'name' => 'Proveedor',
            'sort' => "PROVIDERID",
        ],
        [
            'id' => 'purchaseMethod',
            'name' => 'Método Compra',
            'sort' => "PURCHASEMETHODID",
        ],
        [
            'id' => 'purchaseType',
            'name' => 'Tipo Compra',
            'sort' => "PURCHASETYPEID",
        ],
        [
            'id' => 'motorizationType',
            'name' => 'Tipo de motorización',
            'sort' => "MOTORTYPEID",
        ],
        [
            'id' => 'transmission',
            'name' => 'Caja cambios',
            'sort' => "GEARBOXID",
        ],
        [
            'id' => 'vehicleType',
            'name' => 'Tipo vehículo',
            'sort' => "VEHICLETYPEID",
        ],
        // [
        //     'id' => 'connected',
        //     'name' => 'Vehículo conectado',
        //     'sort' => "CONNECTEDVEHICLE",
        // ],
        // [
        //     'id' => 'firstRegistrationDate',
        //     'name' => 'Fecha alta',
        //     'sort' => "FIRSTREGISTRATIONDATE",
        // ],
        // [
        //     'id' => 'firstRegistrationTime',
        //     'name' => 'Hora alta',
        // ],
        [
            'id' => 'registrationDate',
            'name' => 'Fecha matriculación',
            'sort' => "LASTREGISTRATIONDATE",
        ],
        // [
        //     'id' => 'registrationTime',
        //     'name' => 'Hora matriculación',
        // ],
        [
            'id' => 'deliveryDate',
            'name' => 'Fecha recepción',
            'sort' => "INTDELIVERYDATE",
        ],
        // [
        //     'id' => 'deliveryTime',
        //     'name' => 'Hora recepción',
        // ],
        [
            'id' => 'returnDate',
            'name' => 'Fecha devolución',
            'sort' => "RETURNDATE",
        ],
        // [
        //     'id' => 'returnTime',
        //     'name' => 'Hora devolución',
        // ],
        [
            'id' => 'firstRentDate',
            'name' => 'Fecha inicio alquiler',
            'sort' => "FIRSTRENTDATE",
        ],
        // [
        //     'id' => 'firstRentTime',
        //     'name' => 'Hora inicio alquiler',
        // ],
        [
            'id' => 'rentingEndDate',
            'name' => 'Fecha fin alquiler',
            'sort' => "RENTINGENDDATE",
        ],
        // [
        //     'id' => 'rentingEndTime',
        //     'name' => 'Hora fin alquiler',
        // ],
        [
            'id' => 'byeByeDate',
            'name' => 'Fecha byebye',
            'sort' => "BYEBYEDATE",
        ],
        // [
        //     'id' => 'byeByeTime',
        //     'name' => 'Hora byebye',
        // ],
        [
            'id' => 'initBlockDate',
            'name' => 'Fecha inicio bloqueo',
            'sort' => "INITBLOCKDATE",
        ],
        // [
        //     'id' => 'initBlockTime',
        //     'name' => 'Hora inicio bloqueo',
        // ],
        [
            'id' => 'endBlockDate',
            'name' => 'Fecha fin bloqueo',
            'sort' => "ENDBLOCKDATE",
        ],
        // [
        //     'id' => 'endBlockTime',
        //     'name' => 'Hora fin bloqueo',
        // ],
        // [
        //     'id' => 'movementNumber',
        //     'name' => 'Número movimiento',
        //     'sort' => "MOVEMENTID",
        // ],
        // [
        //     'id' => 'orderNumber',
        //     'name' => 'Número pedido',
        //     'sort' => "PONUMBER",
        // ],
        // [
        //     'id' => 'transportInvoiceNumber',
        //     'name' => 'Número factura transporte',
        //     'sort' => "",
        // ],
        // [
        //     'id' => 'logistic',
        //     'name' => 'Prooveedor transporte',
        //     'sort' => "",
        // ],
        // [
        //     'id' => 'assumedCostBy',
        //     'name' => 'Coste asumido por',
        //     'sort' => "",
        // ],
        // [
        //     'id' => 'actualLoadingDate',
        //     'name' => 'Fecha carga real',
        //     'sort' => "ACTUALLOADDATE",
        // ],
        // [
        //     'id' => 'actualLoadingTime',
        //     'name' => 'Hora carga real',
        // ],
        // [
        //     'id' => 'actualUnloadDate',
        //     'name' => 'Fecha descarga real',
        //     'sort' => "ACTUALUNLOADDATE",
        // ],
        // [
        //     'id' => 'actualUnloadTime',
        //     'name' => 'Hora descarga real',
        // ],
        [
            'id' => 'resaleCode',
            'name' => 'Método venta',
            'sort' => "SALEMETHODID",
        ],
        // [
        //     'id' => 'salesCustomer',
        //     'name' => 'Cliente venta',
        //     'sort' => "",
        // ],
        // [
        //     'id' => 'conditioned',
        //     'name' => 'Acondicionado',
        //     'sort' => "",
        // ],
        [
            'id' => 'rentalAgreementPickUpDate',
            'name' => 'Fecha recogida contrato',
            'sort' => "PICKUPDATE",
        ],
        [
            'id' => 'rentalAgreementPickUpTime',
            'name' => 'Hora recogida contrato',
        ],
        [
            'id' => 'rentalAgreementDropOffDate',
            'name' => 'Fecha devolución contrato',
            'sort' => "DROPOFFDATE",
        ],
        [
            'id' => 'rentalAgreementDropOffTime',
            'name' => 'Hora devolución contrato',
        ],
    ];

    public static function keyExists(string $key): bool
    {
        return array_search($key, array_column(self::$columns, 'id')) !== false;
    }

    /**
     * @param string ...$excludeIdsLike excluye aquellas columnas cuyo id contenga alguna de las cadenas proporcionadas
     * @return array
     */
    public static function getColumns(string ...$excludeIdsLike): array
    {
        if (!empty($excludeIdsLike)) {
            $columnsNotExcluded = [];
            // INFO: Si se utiliza array_filter, $this->json lo devuelve como objeto con índice 0 en lugar de array
            foreach (self::$columns as $col) {
                $exclude = false;
                foreach ($excludeIdsLike as $excludeId) {
                    if (str_contains($col['id'], $excludeId)) {
                        $exclude = true;
                        break;
                    }
                }
                if (!$exclude) {
                    $columnsNotExcluded[] = $col;
                }
            }
            return $columnsNotExcluded;
        }

        return self::$columns;
    }

    /**
     * @return array
     */
    public static function getAllColumns(): array
    {
        return self::$columns;
    }

    /**
     * @return array
     */
    public static function getSortOptions(): array
    {
        $sortOptions = [];
        foreach (self::$columns as $column) {
            if (isset($column['sort'])) $sortOptions[$column['id']] = $column['sort'];
        }
        return $sortOptions;
    }
}
