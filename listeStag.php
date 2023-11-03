<?php 
    include_once("conect.php");
    $query="SELECT * from stagiaires order by CodeGroupe";
    $con->executeQuery($query,array());
    $stmnt= $con->getResults();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Liste Stagiaire</title>
    <link rel="stylesheet" type="text/css" href="LS.css">
</head>

<body>
    <div class="container slide-bottom">
        <h1>Liste des Stagiaires inscrits</h1>
        <table>
            <thead>
                <tr>
                    <th>Code Stagiare</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Groupe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($res=$stmnt->fetch(PDO::FETCH_ASSOC)){
                    ?>
                <tr>
                    <td><?php echo $res["Codestagiaire"] ?></td>
                    <td><?php echo $res["Nom"] ?></td>
                    <td><?php echo $res["Prenom"] ?></td>
                    <td><?php echo $res["CodeGroupe"] ?></td>
                    <td><a name="supp" href="suppStag.php?id=<?php echo $res["Codestagiaire"] ?>">
                    <svg width="30x" height="30px" viewBox="0 -0.21 20.414 20.414" xmlns="http://www.w3.org/2000/svg">
                        <g id="delete-user-5" transform="translate(-2 -2)">
                        <circle id="secondary" fill="#007bff" cx="5" cy="5" r="5" transform="translate(6 3)"/>
                        <path id="primary" d="M21,18l-3-3m0,3,3-3M11,3a5,5,0,1,0,5,5A5,5,0,0,0,11,3Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        <path id="primary-2" data-name="primary" d="M14,13H8a5,5,0,0,0-5,5v1s2,2,8,2a22,22,0,0,0,3-.19" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </g>
                    </svg></a></td>
                    <td><a name="modi" href="modifStag.php?id=<?php echo $res["Codestagiaire"] ?>&nm=<?php echo $res["Nom"] ?>&pnm=<?php echo $res["Prenom"] ?>&cg=<?php echo $res["CodeGroupe"] ?>">
                        <svg width="30px" height="30px" viewBox="0 -0.02 20.109 20.109" xmlns="http://www.w3.org/2000/svg">
                        <g id="edit-user-3" transform="translate(-2 -2)">
                            <circle id="secondary" fill="#007bff" cx="5" cy="5" r="5" transform="translate(6 3)"/>
                            <path id="primary" d="M9,21c-4.45-.37-6-2-6-2V18a5,5,0,0,1,5-5h3" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            <path id="primary-2" data-name="primary" d="M20.71,16.09,15.8,21H13V18.2l4.91-4.91a1,1,0,0,1,1.4,0l1.4,1.4A1,1,0,0,1,20.71,16.09ZM11,3a5,5,0,1,0,5,5A5,5,0,0,0,11,3Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </g>
                        </svg></a>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
            <tfoot>
                <tr><h1>Ajout Stagiaire==> <a href="ajoutStag.php">
                <svg width="40px" height="40px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <g id="add-user-5" transform="translate(-2 -2)">
                            <circle id="secondary" fill="#007bff" cx="5" cy="5" r="5" transform="translate(6 3)"/>
                            <path id="primary" d="M15,13.1a4.71,4.71,0,0,0-1-.1H8a5,5,0,0,0-5,5v1s2,2,8,2a22,22,0,0,0,3-.19,4.542,4.542,0,0,0,1-.17" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            <path id="primary-2" data-name="primary" d="M17,17h4m-2-2v4M11,3a5,5,0,1,0,5,5A5,5,0,0,0,11,3Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </g>
                    </svg>
                </a> </h1>
                
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
