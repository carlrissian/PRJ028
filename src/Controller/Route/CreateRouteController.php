<?php

namespace App\Controller\Route;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CreateRouteController extends Controller
{
    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->render('pages/route/excel.html.twig');
    }
}
