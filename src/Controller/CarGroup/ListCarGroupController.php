<?php
declare(strict_types=1);

namespace App\Controller\CarGroup;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ListCarGroupController extends Controller
{


    public function __invoke(): Response
    {
        return $this->render('pages/cargroup/list.html.twig');
    }
}