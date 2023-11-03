<?php
include("conect.php");
$mod = "";
$groupe = "";
require 'C:/wamp64/www/phpspreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST["modulegroupe"])) {
    $modgroup = $_POST["modulegroupe"];
    $parts = explode('_', $modgroup);
    $mod = $parts[0];
    $groupe = $parts[1];

    $query = "SELECT s.*, n.CodeModule, n.CC1, n.CC2, n.CC3, n.EFM, n.NoteModule
          FROM stagiaires s
          LEFT JOIN notes n ON s.Codestagiaire = n.CodeStagiaire AND n.CodeModule = :mod
          WHERE s.CodeGroupe = :groupe";


    $con->executeQuery($query, array(
        "mod" => array($mod, PDO::PARAM_STR),
        "groupe" => array($groupe, PDO::PARAM_STR)
    ));

    $stmnt = $con->getResults()->fetchAll(PDO::FETCH_ASSOC);
    var_dump($stmnt);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["download"])) {
        $filename = 'listedesnotes.xlsx';
        $file = generateExcel($stmnt);

        // Set the appropriate headers for file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Read the file and output it directly to the browser
        readfile($file);
        exit;
    } elseif (isset($_POST["stagiaire"])) {
        foreach ($_POST["stagiaire"] as $stagiaireId => $values) {
            $cc1 = $values["cc1"];
            $cc2 = $values["cc2"];
            $cc3 = $values["cc3"];
            $efm = $values["efm"];
            $noteGenerale = (($cc1 + $cc2 + $cc3) / 3 + $efm) / 3;

            $query1 = "UPDATE notes SET CC1 = :cc1, CC2 = :cc2, CC3 = :cc3, EFM = :efm, NoteModule = :noteGenerale WHERE CodeStagiaire = :stagiaireId AND CodeModule = :mod";
            $con->executeQuery($query1, array(
                "cc1" => array($cc1, PDO::PARAM_STR),
                "cc2" => array($cc2, PDO::PARAM_STR),
                "cc3" => array($cc3, PDO::PARAM_STR),
                "efm" => array($efm, PDO::PARAM_STR),
                "noteGenerale" => array($noteGenerale, PDO::PARAM_STR),
                "stagiaireId" => array($stagiaireId, PDO::PARAM_INT),
                "mod" => array($mod, PDO::PARAM_STR)
            ));
        }
    }
}

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