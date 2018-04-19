<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 09/04/2018
 * Time: 15:38
 */

/*
 * Ce script permet d'afficher les produit les plus récents dans la boutique
 */
try
{
    //Connexion à la base de donnée
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root','');

    //Requête pour selectionner les produits en fonction de leur date d'ajout
    $query = $bdd->query("SELECT * FROM Produits ORDER BY DateAjout DESC");

    //appel du script d'affichage de produit
    include ('AfficherProduit.php');


}

catch(Exception $e){
    echo " Exception : " .$e->getMessage(). "\n";
}?>
