<?php
session_start();
try{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '');// On se connecte à notre base de données.
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e){

	die('Erreur:' . $e->getmessage());//On affiche une exception quand la connexion n'a pas été effectué.
}

if(isset($_SESSION["id"])) { //On vérifie qu'un utilisateur est connecté.
	$id= $_SESSION["id"];

    $idP=$_GET['id']; // On récupère l'ID de notre produit dans l'URL de la page.

    $supprimer = $bdd->prepare("DELETE FROM panier WHERE Produit = '$idP'"); // On supprime l'entrée donc l'ID du produit correspond à l'idP récupéré.
    $supprimer-> execute();

    header('location: panier.php');//Après l'exécution de notre requête, on revient directement à notre panier.

} else {
	die("Vous n'avez pas de commandes");//Si l'utilisateur n'est pas connecté ou qu'il ne possède pas de commandes on le préviens qu'il ne possède pas de commandes.
}
