<?php
declare(strict_types=1);


namespace App\Controller;


use Locale;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class Controller extends AbstractController
{
    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $locale = Locale::getDefault();
        $parameters['menus'] =  Yaml::parseFile(__DIR__ . "/../../config/menus/menu.$locale.yaml");
        $parameters['user'] = $_SESSION['UserInfo'] ?? null;
        $parameters['constantsManager'] = json_decode(ConstantsJsonFile::getAllConstants(), true);

        return parent::render($view, $parameters, $response);
    }
}