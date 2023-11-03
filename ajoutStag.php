<?php 
    include("conect.php");
    $query = "SELECT * from groupes";
    $con->executeQuery($query, array());
    $stmnt = $con->getResults();
    var_dump($stmnt);
    
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) &&  !empty($_POST['code-groupe'])) {

        $query2 = "INSERT into stagiaires(nom, prenom, Codegroupe) Values(:nm, :pnm, :cg)";
        $con->executeQuery($query2, array(
            'nm' => array($_POST['nom'], PDO::PARAM_STR),
            'pnm' => array($_POST['prenom'], PDO::PARAM_STR),
            'cg' => array($_POST['code-groupe'], PDO::PARAM_STR)
        ));
        header("Location:listeStag.php");
    }
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire Insertion Stagiaire</title>
    <link rel="stylesheet" type="text/css" href="IS.css">
</head>
<body>
    <div class="container slide-bottom">
        <h1>AJOUT STAGIAIRE</h1>
        <form method="POST" action="ajoutStag.php">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="code-groupe">Groupe Stagiaire:</label>
            <select name="code-groupe" required>
                <?php while ($res = $stmnt->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo $res['CodeGpe']; ?>"><?php echo $res['Libelle'] ?></option>
                <?php endwhile; ?>
            </select>

            <input type="submit" value="Envoyer">
        </form>
    </div>
</body>
</html>
