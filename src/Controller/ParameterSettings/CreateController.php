<?php

namespace App\Controller\ParameterSettings;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CreateController extends Controller
{
    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->render('pages/parameter_settings/create.html.twig');
    }
}
