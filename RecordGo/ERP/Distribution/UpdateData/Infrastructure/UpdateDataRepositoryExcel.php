<?php

namespace Distribution\UpdateData\Infrastructure;

use Shared\Utils\ExcelUtils;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Distribution\UpdateData\Domain\FileRepository;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use Distribution\UpdateData\Domain\VehicleExcelConstants;

class UpdateDataRepositoryExcel implements FileRepository
{
    /**
     * @inheritDoc
     */
    public function import(\SplFileInfo $file): array
    {
        $reader = new XlsxReader();

        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getActiveSheet();

        $headers = [];
        $dataList = [];
        $lastHeaderIndex = null;
        foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
            $cellIterator = $row->getCellIterator();

            // Comprobar si en la siguiente fila hay datos
            if ($lastHeaderIndex) {
                $hasData = false;
                foreach ($cellIterator as $columnIndex => $cell) {
                    if (!is_null($cell->getValue())) {
                        $hasData = true;
                        break;
                    }
                    if (str_contains($columnIndex, $lastHeaderIndex)) {
                        break;
                    }
                }
                if (!$hasData) {
                    break;
                }
            }


            if ($rowIndex === 1) {
                $headers = array_map(function ($cell) {
                    return $cell->getValue();
                }, iterator_to_array($cellIterator));
                $notEmptyHeaders = array_filter($headers, function ($value) {
                    return !is_null($value);
                });


                // Obtener las cabeceras (incluyendo nulas)
                $headers = array_filter($headers, function ($value, $index) use ($notEmptyHeaders) {
                    return ExcelUtils::columnLettersToNumber($index) <= ExcelUtils::columnLettersToNumber(array_key_last($notEmptyHeaders)) || !is_null($value);
                }, ARRAY_FILTER_USE_BOTH);

                $lastHeaderIndex = array_key_last($headers);

                // Reemplazar los índices por números
                $headers = array_values($headers);
            } else {
                $line = [];
                $line["line"] = $rowIndex;

                foreach ($cellIterator as $columnIndex => $cell) {
                    $columnName = $worksheet->getCell("{$columnIndex}1")->getValue();
                    $value = null;
                    if (!is_null($cell->getValue())) {
                        $value = str_contains(strtolower($columnName), 'fecha') ? ExcelUtils::convertExcelTImeToTimestamp($cell->getValue()) : trim($cell->getValue());
                    }
                    $line[$columnName] = $value;

                    if (str_contains($columnIndex, $lastHeaderIndex)) {
                        break;
                    }
                }

                $dataList[] = $line;
            }
        }

        return [$headers, $dataList];
    }

    /**
     * @inheritDoc
     */
    public function template(
        array $dropdownLists,
        string $fileName = 'update_vehicle_data_template',
        bool $returnFile = false
    ) {
        $headers = VehicleExcelConstants::toArray();

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        /**
         * Crear listados de ocpiones en una hoja oculta
         */
        $dropdownCols = [];
        $spreadsheet->createSheet();
        $sheet = $spreadsheet->setActiveSheetIndex(1);
        $sheet->setTitle('DropdownLists');

        $col = 'A';
        foreach ($dropdownLists as $head => $dropdownList) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getColumnDimension($col)->setVisible(false);

            $row = 1;
            foreach ($dropdownList['values'] as $value) {
                $sheet->setCellValue("{$col}{$row}", $value);
                $row++;
            }

            $dropdownCols[$head] = [
                'index' => $col,
                'allowBlank' => $dropdownList['allowBlank'],
                'listRange' => "'{$sheet->getTitle()}'!\${$col}\$1:\${$col}\$" . (count($dropdownList['values'])),
            ];

            $col++;
        }

        // Ocultar la hoja
        $sheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_VERYHIDDEN);
        /* */


        // Retrieve the current active worksheet
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $col = 'A';
        foreach ($headers as $head) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->setCellValue("{$col}1", $head);

            if (array_key_exists($head, $dropdownCols)) {
                $startRow = 2;
                $endRow = 1000;

                $validation = $sheet->getCell("{$col}{$startRow}")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);

                // Referencia al rango oculto
                $validation->setFormula1($dropdownCols[$head]['listRange']);

                // INFO: no se puede utilizar así porque el rango de caracteres máximo de la lista es 255
                // $validation->setFormula1('"' . implode(',', $dropdownCols[$head]['values']) . '"');

                $validation->setAllowBlank($dropdownCols[$head]['allowBlank']);
                $validation->setShowDropDown(true);
                // INFO: campos para tooltip
                // $validation->setShowInputMessage(true);
                // $validation->setPromptTitle('Note');
                // $validation->setPrompt('Must select one from the drop down options.');
                $validation->setShowErrorMessage(true);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setErrorTitle('Invalid option');
                $validation->setError('Select an option from the drop down list.');

                // Aplicar la validación al rango completo
                for ($i = $startRow + 1; $i <= $endRow; $i++) {
                    $sheet->getCell("{$col}{$i}")->setDataValidation(clone $validation);
                }
            }

            $col++;
        }

        if ($returnFile) {
            return $spreadsheet;
        } else {
            // Guardar el archivo
            $tempFile = tempnam(sys_get_temp_dir(), "{$fileName}.xlsx");
            $writer = new XlsxWriter($spreadsheet);
            $writer->save($tempFile);
            return [
                $tempFile,
                "{$fileName}.xlsx",
            ];
        }
    }
}
