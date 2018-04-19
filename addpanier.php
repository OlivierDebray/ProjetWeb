<?php

try{
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');//On se connecte à notre base de données.
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e){

    die('Erreur:' . $e->getmessage());//On renvoie une exception si la connexion n'a pas pu être effectué.
}

if(isset($_SESSION["id"])) {//On vérifie qu'un utilisateur est connecté en récupérant l'ID.
    $id= $_SESSION["id"];

    $reqpanier = $bdd->prepare("SELECT * FROM produits INNER JOIN panier ON produits.ID_Produits = panier.Produit WHERE panier.Utilisateur = '$id'");//On sélectionne l'ensemble de la table produits et panier lorsque l'ID_Produits de la table produits correspond à un Produit de la table panier. Et cela seulement pour les paniers concernant l'utilisateur connecté.
    $reqpanier->execute();

    while($donnée = $reqpanier->fetch())//On parcourt l'ensemble des données récupérées.
    { ?>
        <div class="row" id="row<?php echo $donnée['Produit']; ?>">  <!--On récupère les différentes données à l'aide de $donnée[''] et on les affiches dans le code HTML. --> 
            <img alt="produit" class="img" src='images/produits/<?php echo $donnée['url']?>'>
            <span class= "name"><?php echo $donnée['Nom']?></span>
            <span class="price"><?php echo ($donnée['Prix'] * $donnée['Quantite']) ?></span>
            <span class="Quantity"> <?php echo $donnée['Quantite']; ?></span>
            <img onclick="removeFromCart(<?php echo $donnée['Produit']; ?>)" class="corb" src="images/corbeille.jpg" alt="suppr"/>
        </div>
        <br/>
        <?php
    }
}
else {
    die("Vous n'avez pas de commandes"); // Si l'utilisateur n'est pas connecté, on lui précise qu'il n'a pas de commande.
}

?>