<?php

namespace App\Controller\Route;

use App\Helpers;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Route\Application\DownloadExcelTemplate\DownloadExcelTemplateRouteQueryHandler;

class DownloadExcelTemplateRouteController extends AbstractController
{
    /**
     * @var DownloadExcelTemplateRouteQueryHandler
     */
    private DownloadExcelTemplateRouteQueryHandler $handler;

    /**
     * @param DownloadExcelTemplateRouteQueryHandler $handler
     */
    public function __construct(DownloadExcelTemplateRouteQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return Response
     */
    public function __invoke(): StreamedResponse
    // public function __invoke(): BinaryFileResponse
    {
        $response = $this->handler->handle();
        return Helpers::exportCsv([], $response->getHeaders(), $response->getFileName());

        // TODO descomentar cuando se cambie el CSV por excel
        // $handlerResponse = $handler->handle();
        // $response = new BinaryFileResponse($handlerResponse->getTempFile());
        // $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $handlerResponse->getFileName() ?? $response->getFile()->getFilename());
        // return $response;
    }
}
