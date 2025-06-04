<?php
declare(strict_types=1);


namespace App\Controller\FleetClassification;

use App\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

class FleetClassificationController extends Controller
{
    /**
     * @var string
     */
    public static string $FLASH_OK = 'success';
    /**
     * @var string
     */
    public static string $FLASH_WARNING = 'warning';
    /**
     * @var string
     */
    public static string $FLEET_CLASSIFICATION_LIST_ROUTE = 'fleetclassification.list';


    public function associatePage(): Response
    {
        return $this->render('pages/fleetClassification/associate.html.twig');
    }

}
