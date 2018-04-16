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
<<<<<<< HEAD
    {
        ?>
               <div class='product'> 
                    <div class='name'><?php echo $donnes['Nom']?></div>
=======
    {?>
               <div class='product'> 
                    <div class='name'> <?php echo $donnes['Nom']?></div>
>>>>>>> shop
                    <img src='images/produits/<?php echo $donnes['url']?>', class='imgprod' />
                    
                    <div class='price'> Prix: <?php echo $donnes['Prix']?></div>
                    
<<<<<<< HEAD
                    
                    <div class='price'> Prix: <?php echo $donnes['Prix']?></div>
                    
                    <div class='description'> Description : <?php echo $donnes['Description']?></div>
                    
                   <button><a href="AjoutBDDpanier.php?idproduit=<?php echo $donnes['ID_Produits']; ?>"> Ajouter au panier</a></button>
                </div>


<?php
=======
                    <div class='description'> Description: <?php echo$donnes['Description']?></div>
                    
                    <a href=''> <button> Ajouter au Panier </button></a>
                </div>

        <?php
>>>>>>> shop
    }

}


catch(Exception $e){
    echo " Exception : " .$e->getMessage(). "\n";
}?>
