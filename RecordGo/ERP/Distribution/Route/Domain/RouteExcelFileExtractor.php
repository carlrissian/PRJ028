<?php
declare(strict_types=1);


namespace Distribution\Route\Domain;


use SplFileInfo;

interface RouteExcelFileExtractor
{
    public function extract(SplFileInfo $file): array;
}