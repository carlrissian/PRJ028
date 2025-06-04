<?php
declare(strict_types=1);

namespace App\Controller\CommercialGroup;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ListCommercialGroupController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('pages/commercialgroup/list.html.twig');
    }
}