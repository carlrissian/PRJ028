<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PruebaController extends Controller
{

    public function index(SessionInterface $session)
    {
        return $this->render('pages/prueba/index.html.twig', [
            'controller_name' => 'PruebaController',
            'token' => $_SESSION['SapSessionId']
        ]);
    }
}