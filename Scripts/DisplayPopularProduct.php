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


    while ($donnes = $getPopular->fetch())
    {
         echo" 
               <div class='product'> 
                    <div class='name'> {$donnes['Nom']}</div>
                    
                    
                    
                    <div class='price'> Prix: {$donnes['Prix']}</div>
                    
                    <div class='description'> Description : {$donnes['Description']}</div>
                </div>";
    }

    //<img src='{$donnes['Url']}', class='imgprod' />
}
catch(Exception $e){
    echo " Exception : " .$e->getMessage(). "\n";
}

