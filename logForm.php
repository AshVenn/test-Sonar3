<?php
include("conect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricule = $_POST["matricule"];
    $motDePasse = $_POST["mot_de_passe"];

    $query = "SELECT * FROM formateur WHERE Matricule = :matricule";
    $con->executeQuery($query, array(
        'matricule' => array($matricule, PDO::PARAM_STR)
    ));
    $stmnt = $con->getResults();
    $user = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($user && $motDePasse == $user['mdp']) {
        header("Location: espacForm.php?id=" . $user['Matricule']);
        exit();
    } else {
        echo "Matricule ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login formateur</title>
    <link rel="stylesheet" href="IS.css">
</head>
<body>
    <div class="container slide-bottom">
    <h1>Veuillez vous connecter à votre espace formateur:</h1>
    <form method="POST" action="logForm.php">
        <label for="matricule">Matricule :</label>
        <input type="text" name="matricule" id="matricule" required><br>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" required>

        <input type="submit" value="Connecter">
    </form>
</div>
</body>
</html>
