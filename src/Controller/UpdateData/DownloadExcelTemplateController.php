<?php

namespace App\Controller\UpdateData;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\UpdateData\Application\DownloadExcelTemplate\DownloadExcelTemplateUpdateDataQueryHandler;

class DownloadExcelTemplateController extends AbstractController
{
    /**
     * @return Response
     */
    public function __invoke(DownloadExcelTemplateUpdateDataQueryHandler $handler): BinaryFileResponse
    {
        $handlerResponse = $handler->handle();
        $response = new BinaryFileResponse($handlerResponse->getTempFile());
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $handlerResponse->getFileName() ?? $response->getFile()->getFilename());
        return $response;
    }
}
