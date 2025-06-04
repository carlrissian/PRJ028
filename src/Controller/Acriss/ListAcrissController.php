<?php

namespace App\Controller\Acriss;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ListAcrissController extends Controller
{
    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->render('pages/acriss/list.html.twig');
    }
}
