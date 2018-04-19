<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 16/04/2018
 * Time: 13:25
 */

/* Ce script permet d'afficher un produit ou article en affichant son Nom, son Image, son Prix, sa Description et un bouton ajouter au panier

Toutes les pages qui utilisent se script et qui nécessitent de se connecter à une BDD devront
avoir une variable $query contenant la requete voulue
*/

//query fetch pour recupérer les valeur en fonction de nom de colonne dans la BDD
while ($reponse = $query->fetch())
{?>
    <div class='product'>
        <a href="pageProduit.php?produit=<?php echo $reponse['ID_Produits'] ?>"> <div class='name'> <?php echo $reponse['Nom']?></div>
        <img src='images/produits/<?php echo $reponse['url']?>' class='imgprod' alt="image" />
        </a>

        <div class='price'> Prix: <?php echo $reponse['Prix']?></div>

        <div class='description'> Description: <?php echo$reponse['Description']?></div>

        <button onclick="addToCart(<?php echo $reponse['ID_Produits']; ?>)">Ajouter au
            panier
        </button>
        <label id="label<?php echo $reponse['ID_Produits']; ?>"></label>
    </div>
    <?php
}