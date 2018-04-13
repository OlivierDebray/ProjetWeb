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

    $getPopular = $bdd->query("SELECT * FROM `produits` 
    ORDER BY DateAjout DESC");


    while ($donnes = $getPopular->fetch())
    {
        ?>
               <div class='product'> 
                    <div class='name'><?php echo $donnes['Nom']?></div>
                    <img src='images/produits/<?php echo $donnes['url']?>', class='imgprod' />
                    
                    
                    
                    <div class='price'> Prix: <?php echo $donnes['Prix']?></div>
                    
                    <div class='description'> Description : <?php echo $donnes['Description']?></div>
                    
                   <button><a href="AjoutBDDpanier.php?idproduit=<?php echo $donnes['ID_Produits']; ?>"> Ajouter au panier</a></button>
                </div>


<?php
    }

}


catch(Exception $e){
    echo " Exception : " .$e->getMessage(). "\n";
}
