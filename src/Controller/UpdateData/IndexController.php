<?php

namespace App\Controller\UpdateData;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->render('pages/updateData/index.html.twig');
    }
}
