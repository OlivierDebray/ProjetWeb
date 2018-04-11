<?php

$bdd = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '');

$id= $_SESSION["id"];

$reqpanier = $bdd->prepare('SELECT * FROM panier WHERE ID_Utilisateur = $id')
$reqpanier->execute();
?>