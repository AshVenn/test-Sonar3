<?php
include("conect.php");
include("generateExcelnote.php");
$mod = "";
$groupe = "";

if (isset($_POST["modulegroupe"])) {
    $modgroup = $_POST["modulegroupe"];
    $parts = explode('_', $modgroup);
    $mod = $parts[0];
    $groupe = $parts[1];

    // Select les stagiaire wtcreer lihom lignes fnotes lamlçatch lcouple mod m3a costg mkynch
    $querySelect = "SELECT s.Codestagiaire FROM stagiaires s LEFT JOIN notes n ON s.Codestagiaire = n.CodeStagiaire AND n.CodeModule = :mod WHERE s.CodeGroupe = :groupe AND n.CodeStagiaire IS NULL";
    $con->executeQuery($querySelect, array(
        "mod" => array($mod, PDO::PARAM_STR),
        "groupe" => array($groupe, PDO::PARAM_STR)
    ));

    $queryInsert = "INSERT INTO notes (CodeStagiaire, CodeModule) VALUES (:codestagiaire, :mod)";
    $statement = $con->prepare($queryInsert);

    $result = $con->getResults();

    // insertion dyal douk lines
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $codestagiaire = $row['Codestagiaire'];

        $statement->execute(array(
            ':codestagiaire' => $codestagiaire,
            ':mod' => $mod
        ));
    }
}

$querySelect = "SELECT s.*, n.CodeModule, n.CC1, n.CC2, n.CC3, n.EFM, n.NoteModule
          FROM stagiaires s
          LEFT JOIN notes n ON s.Codestagiaire = n.CodeStagiaire AND n.CodeModule = :mod
          WHERE s.CodeGroupe = :groupe";

$con->executeQuery($querySelect, array(
    "mod" => array($mod, PDO::PARAM_STR),
    "groupe" => array($groupe, PDO::PARAM_STR)
));

$stmnt = $con->getResults()->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["download"])) {
        $filename = 'listedesnotes.xlsx';
        $file = generateExcel($stmnt);

        // Set the appropriate headers for file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($file));
        readfile($file);

        // Delete the temporary file
        unlink($file);

        // Exit the script
        exit();
    }
}


//hadi dyal affichage
$query = "SELECT s.*, n.CodeModule, n.CC1, n.CC2, n.CC3, n.EFM, n.NoteModule
          FROM stagiaires s
          LEFT JOIN notes n ON s.Codestagiaire = n.CodeStagiaire AND n.CodeModule = :mod
          WHERE s.CodeGroupe = :groupe";

$con->executeQuery($query, array(
    "mod" => array($mod, PDO::PARAM_STR),
    "groupe" => array($groupe, PDO::PARAM_STR)
));

$stmnt = $con->getResults()->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ListeNotes stagiaires</title>
    <link rel="stylesheet" href="LS.css">
</head>
<body>
    <div class="container slide-bottom">
        <form method="POST" action="listeNotesStag.php">
            <table>
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Groupe</th>
                        <th>Stagiaire</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>CC1</th>
                        <th>CC2</th>
                        <th>CC3</th>
                        <th>EFM</th>
                        <th>Note Génerale</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stmnt as $row) { ?>
                        <tr>
                            <td><?php echo $mod; ?></td>
                            <td><?php echo $row['CodeGroupe']; ?></td>
                            <td><?php echo $row['Codestagiaire']; ?></td>
                            <td><?php echo $row['Nom']; ?></td>
                            <td><?php echo $row['Prenom']; ?></td>
                            <td><input type="text" name="stagiaire[<?php echo $row['Codestagiaire']; ?>][cc1]" value="<?php echo $row['CC1']; ?>"></td>
                            <td><input type="text" name="stagiaire[<?php echo $row['Codestagiaire']; ?>][cc2]" value="<?php echo $row['CC2']; ?>"></td>
                            <td><input type="text" name="stagiaire[<?php echo $row['Codestagiaire']; ?>][cc3]" value="<?php echo $row['CC3']; ?>"></td>
                            <td><input type="text" name="stagiaire[<?php echo $row['Codestagiaire']; ?>][efm]" value="<?php echo $row['EFM']; ?>"></td>
                            <td><input type="text" value="<?php echo $row['NoteModule']; ?>" readonly></td>
                            <td><input type="hidden" name="stagiaire[<?php echo $row['Codestagiaire']; ?>][id]" value="<?php echo $row['Codestagiaire']; ?>"></td>

                        </tr>
                    <?php } ?>
                    <input type="hidden" name="modulegroupe" value="<?php echo $_POST["modulegroupe"]?>">
                </tbody>
            </table>
            <input type="submit" name="download" value="Télécharger">
            <input type="submit" value="Enregistrer">
        </form>
    </div>
</body>
</html>