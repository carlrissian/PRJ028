<?php

namespace App\Controller\Acriss;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CreateAcrissController extends Controller
{
    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->render('pages/acriss/create.html.twig');
    }
}
