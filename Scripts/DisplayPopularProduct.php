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
    ?>
               <div class='product'> 
                    <div class='name'> {$donnes['Nom']}</div>
                    
                    <img src='images/produits/{$donnes['url']}', class='imgprod' />
                    
                    
                    <div class='price'> Prix : {$donnes['Prix']}</div>
                    
                    <div class='description'> Description : {$donnes['Description']}</div>
                    
                    <a href="AjoutBDDpanier.php?id=<?php echo $donnes['ID_Produits']; ?>"> Ajouter au panier</a>
                </div>

<?php
    }


}
catch(Exception $e){
    echo " Exception : " .$e->getMessage(). "\n";
}

