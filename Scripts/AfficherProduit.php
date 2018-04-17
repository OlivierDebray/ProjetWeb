<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 16/04/2018
 * Time: 13:25
 */

while ($reponse = $query->fetch())
{?>
    <div class='product'>
        <div class='name' href="pageProduit.php?val=<?php echo $reponse['ID_Produits'] ?>"> <?php echo $reponse['Nom']?></div>
        <img src='images/produits/<?php echo $reponse['url']?>', class='imgprod' />

        <div class='price'> Prix: <?php echo $reponse['Prix']?></div>

        <div class='description'> Description: <?php echo$reponse['Description']?></div>

        <button onclick="addToCart(<?php echo $reponse['ID_Produits']; ?>)">Ajouter au
            panier
        </button>
    </div>
    <?php
}