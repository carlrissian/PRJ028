<?php

namespace App\Controller\Vehicle;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ConsultController extends Controller
{
    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->render('pages/vehicle/consult.html.twig');
    }
}
