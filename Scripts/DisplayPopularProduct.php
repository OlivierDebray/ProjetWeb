<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 09/04/2018
 * Time: 15:38
 */

/*
 * Ce script permet d'afficher les produit les plus populaire dans la boutique
 */

try {


    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');


    $query = $bdd->prepare("SELECT * FROM produits 
    WHERE ID_Produits IN (SELECT Produit FROM `commande` 
    GROUP BY Produit ORDER BY COUNT(Produit) DESC) LIMIT 3 ");

    $query->execute();


    include ('AfficherProduit.php');

}



catch(Exception $e){
    echo " Exception : " .$e->getMessage(). "\n";
}
?>

