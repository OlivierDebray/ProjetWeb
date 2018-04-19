<?php
    /*
     * On récupère toutes les données de la table évènements
     */
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
    $requete = $bdd->prepare("SELECT * FROM evenements");
    $requete->execute();
    $activities = $requete -> fetchAll();

?>
