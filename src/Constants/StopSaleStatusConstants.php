<?php
declare(strict_types=1);


namespace App\Constants;


class StopSaleStatusConstants extends Constants
{
    public const STOPSALE_STATUS_ACTIVE = 1; // fecha inicio y fecha fin no finalizada
    public const STOPSALE_STATUS_CANCELED = 2; // Cancel = true, cancelado por usuario
    public const STOPSALE_STATUS_FINISHED = 3; // Cancel = false y fecha fin menor que hoy

    public const STOPSALE_STATUS_ACTIVE_NAME = 'Activado';
    public const STOPSALE_STATUS_CANCELED_NAME = 'Anulado';
    public const STOPSALE_STATUS_FINISHED_NAME = 'Finalizado';

}