<?php 
include("conect.php");
$query="DELETE from stagiaires where Codestagiaire=:id";
$con->executeQuery($query,
array('id'=>array($_GET['id'],PDO::PARAM_INT)));
header('Location:listeStag.php');  
?>