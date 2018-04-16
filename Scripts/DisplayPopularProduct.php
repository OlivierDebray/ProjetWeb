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


    $query = $bdd->query("SELECT * FROM produits 
    WHERE ID_Produits IN (SELECT Produit FROM `commande` 
    GROUP BY Produit ORDER BY COUNT(Produit) DESC)  ");


    while ($response = $query->fetch())
    {?>
               <div class='product'> 
                    <div class='name'> <?php echo $response['Nom']?></div>
                    
                    <img src='images/produits/<?php echo $response['url']?>' class='imgprod'/>
                    
                    
                    <div class='price'> Prix : <?php echo $response['Prix'] ?></div>
                    
                    <div class='description'> Description :<?php echo $response['Description']?></div>
                    
                    <a href=''> <button> Ajouter au Panier </button></a>
                </div>
<?php
    }


}
catch(Exception $e){
    echo " Exception : " .$e->getMessage(). "\n";
}?>

