<?php
declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class Helpers
{

    public static function exportCsv($array, $headers = null, $filename = null, $delimiter = ';')
    {
        header('Content-Encoding: UTF-8');

        $response = new StreamedResponse();
        $response->setCallback(function () use ($array, $headers, $delimiter) {
            $f = fopen('php://memory', 'w');

            fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM para UTF-8
            if ($headers) {
                fputcsv($f, array_values($headers), $delimiter);
            }
            foreach ($array as $line) {
                fputcsv($f, $line, $delimiter);
            }
            fseek($f, 0);
            fpassthru($f);
        });
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        return $response;
    }

    public static function nameFileUnique($name = null, $extension = 'csv'): string
    {
        if ($name) {
            [$name, $extension] = explode('.', $name);
        } else {
            $name = 'File';
        }
        return $name . '_' . date('d-m-Y') . '_' . time() . '.' . $extension;
    }

    public static function formatterAccent($string)
    {

        return str_replace([
            'Á',
            'À',
            'Â',
            'Ä',
            'á',
            'à',
            'ä',
            'â',
            'ª',
            'É',
            'È',
            'Ê',
            'Ë',
            'é',
            'è',
            'ë',
            'ê',
            'Í',
            'Ì',
            'Ï',
            'Î',
            'í',
            'ì',
            'ï',
            'î',
            'Ó',
            'Ò',
            'Ö',
            'Ô',
            'ó',
            'ò',
            'ö',
            'ô',
            'Ú',
            'Ù',
            'Û',
            'Ü',
            'ú',
            'ù',
            'ü',
            'û'
        ], [
            'A',
            'A',
            'A',
            'A',
            'a',
            'a',
            'a',
            'a',
            'a',
            'E',
            'E',
            'E',
            'E',
            'e',
            'e',
            'e',
            'e',
            'I',
            'I',
            'I',
            'I',
            'i',
            'i',
            'i',
            'i',
            'O',
            'O',
            'O',
            'O',
            'o',
            'o',
            'o',
            'o',
            'U',
            'U',
            'U',
            'U',
            'u',
            'u',
            'u',
            'u'
        ], $string);

    }

    public static function getArrayCollection($response): array
    {
        return array_map(function ($object) {
            return $object->toArray();
        }, $response->getCollection()->toArray());
    }

    public static function getArrayClass($array): array
    {
        return array_map(function ($object) {
            return $object->toArray();
        }, $array);
    }

    public static function getArrayClassValue($array, $field): array
    {
        return array_map(function ($object) use ($field) {
            $name = 'get' . ucwords($field);
            return $object->$name();
        }, $array);

    }
}