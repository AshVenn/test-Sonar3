<?php
require 'C:/wamp64/www/phpspreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function generateExcel($data)
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // les colonnes
    $headers = ['Module', 'Groupe', 'Stagiaire', 'Nom', 'Prénom', 'CC1', 'CC2', 'CC3', 'EFM', 'Note Génerale'];
    $sheet->fromArray($headers, NULL, 'A1');

    // table data
    $rowData = [];
    foreach ($data as $row) {
        $rowData[] = [
            $row['CodeModule'],
            $row['CodeGroupe'],
            $row['Codestagiaire'],
            $row['Nom'],
            $row['Prenom'],
            $row['CC1'],
            $row['CC2'],
            $row['CC3'],
            $row['EFM'],
            $row['NoteModule']
        ];
    }
    $sheet->fromArray($rowData, NULL, 'A2');

    // fichier temporaire
    $tempFile = tempnam(sys_get_temp_dir(), 'excel');
    $writer = new Xlsx($spreadsheet);
    $writer->save($tempFile);

    return $tempFile;
}
?>
