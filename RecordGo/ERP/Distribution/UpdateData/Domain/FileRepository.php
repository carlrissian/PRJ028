<?php

namespace Distribution\UpdateData\Domain;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

interface FileRepository
{
    /**
     * @param \SplFileInfo $file
     * @return array
     */
    public function import(\SplFileInfo $file): array;

    /**
     * @param array $dropdownLists
     * @param string $fileName
     * @param boolean $returnFile
     * @return Xlsx|array
     */
    public function template(array $dropdownLists, string $fileName = '', bool $returnFile = false);
}
