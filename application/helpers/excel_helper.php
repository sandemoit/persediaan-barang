<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function export_excel($filename, $data)
{
    // create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // get active sheet
    $sheet = $spreadsheet->getActiveSheet();

    // set header row
    $header = array_keys($data[0]);
    foreach ($header as $key => $value) {
        $sheet->setCellValueByColumnAndRow($key + 1, 1, $value);
    }

    // set data rows
    $row = 2;
    foreach ($data as $key => $value) {
        $col = 1;
        foreach ($value as $k => $v) {
            $sheet->setCellValueByColumnAndRow($col, $row, $v);
            $col++;
        }
        $row++;
    }

    // create new Xlsx object and save file
    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);
}
