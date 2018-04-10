<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 09/04/2018
 * Time: 15:38
 */

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root','');
    $getNewest = $bdd->query("SELECT * FROM Produits");

    $getPopular = $bdd->query("SELECT * FROM produits 
    WHERE ID_Produits IN (SELECT Produit FROM `commande` 
    GROUP BY Produit ORDER BY COUNT(Produit) DESC)  ");


    while ($donne = $getPopular->fetch())
    {
        echo $donne['Nom'];
    }
}
catch(Exception $e){
    echo " Exception : " .$e->getMessage(). "\n";
}

