<?php
session_start();

	$bdd = new PDO('mysql:host=localhost;dbname=projetweb', 'root', ''); // On se connecte à notre base de données.


    if(isset($_SESSION["id"])) { // On vérifie que l'utilisateur est bien connecté.
	$id= $_SESSION["id"];

    $supprimer = $bdd->prepare("DELETE FROM panier WHERE Utilisateur = '$id'"); // On supprime l'ensemble des articles de notre panier.
    $supprimer-> execute();

header('location: panier.php');// Après l'exécution de notre requête, on revient directement à notre page panier.

} else {
	die("Vous n'avez pas de commandes"); //On prévient l'utilisateur, s'il n'est pas connecté ou bien s'il n'a pas de panier.
}

?>