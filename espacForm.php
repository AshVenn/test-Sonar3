<?php
include("conect.php");
$id = $_GET['id'];
$query = "SELECT f.*, mgf.cdmd, mgf.cdgrp FROM formateur f INNER JOIN modulegroupeform mgf ON f.Matricule = mgf.cdform WHERE mgf.cdform = :id";
$con->executeQuery($query, array(
    'id' => array($id, PDO::PARAM_STR)
));
$results = $con->getResults()->fetchAll(PDO::FETCH_ASSOC);
//var_dump($results);
//echo "Bonjour " . $results[0]["Nom"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Formateur</title>
    <link rel="stylesheet" href="IS.css">
    <script src="code.jquery.com_jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function(){

            $('#md').change(function() {
                $('#myForm').submit();
            });
        }
        
        );
    </script>
</head>
<body>
    <div class="container slide-bottom">
    <h1><?php echo "Bonjour " . $results[0]["Nom"];?></h1>
    <form id="myForm" method="POST" action="listeNotesStag.php">
        
        <select name="modulegroupe" id="md">
            
            <option readonly>choisir MODULE-GROUPE...</option>
            <?php
            
            foreach ($results as $row) {
                $cdmd = $row["cdmd"];
                $cdgrp = $row["cdgrp"];
                $cdmd_values = explode(',', $cdmd);
                $cdgrp_values = explode(',', $cdgrp);
                foreach ($cdmd_values as $cdmd_value) {
                    foreach ($cdgrp_values as $cdgrp_value) {
                        $option_text = $cdmd_value . " - " . $cdgrp_value;
                        $option_value = $cdmd_value . "_" . $cdgrp_value;
                        echo "<option value=\"$option_value\">$option_text</option>";
                    }
                }
            }
            ?>
        </select>
    </form></div>
</body>
</html>
