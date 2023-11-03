<?php 
    include("conect.php");
    $query = "SELECT * from groupes";
    $con->executeQuery($query, array());
    $stmnt = $con->getResults();
    var_dump($stmnt);
    
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) &&  !empty($_POST['code-groupe'])) {

        $query2 = "UPDATE stagiaires SET nom=:nm, prenom=:pnm, Codegroupe=:cg WHERE Codestagiaire=:id";
        $con->executeQuery($query2, array(
            'id' => array($_POST["id"], PDO::PARAM_INT),
            'nm' => array($_POST["nom"], PDO::PARAM_STR),
            'pnm' => array($_POST["prenom"], PDO::PARAM_STR),
            'cg' => array($_POST["code-groupe"], PDO::PARAM_STR)
        ));
        header("Location:listeStag.php");
    }
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire Modification Stagiaire</title>
    <link rel="stylesheet" type="text/css" href="IS.css">
</head>
<body>
    <div class="container slide-bottom">
        <h1>Modifier STAGIAIRE</h1>
        <form method="POST" action="modifStag.php">
            <label>Code Stagiaire:</label>
            <input name="id" value="<?php echo $_GET["id"] ?>" readonly>
            <label for="nom">Nom:</label>
            <input value="<?php echo $_GET["nm"] ?>" type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom:</label>
            <input value="<?php echo $_GET["pnm"] ?>" type="text" id="prenom" name="prenom" required>

            <label for="code-groupe">Groupe Stagiaire:</label>
            <select name="code-groupe" required>
                <option value="<?php echo $_GET["cg"] ?>"><?php echo"couramment".$_GET["cg"] ?></option>
                <?php while ($res = $stmnt->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo $res['CodeGpe']; ?>"><?php echo $res['Libelle'] ?></option>
                <?php endwhile; ?>
            </select>

            <input type="submit" value="Envoyer">
        </form>
    </div>
</body>
</html>
