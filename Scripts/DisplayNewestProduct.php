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
    $query = $bdd->query("SELECT * FROM Produits ORDER BY DateAjout DESC");


    include ('AfficherProduit.php');

}
catch(Exception $e){
    echo " Exception : " .$e->getMessage(). "\n";
}?>
