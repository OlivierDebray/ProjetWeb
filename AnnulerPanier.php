<?php
session_start();
try{
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
    // On se connecte à notre base de données.
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);


    if(isset($_SESSION["id"])) { // On vérifie que l'utilisateur est bien connecté.

        $id= $_SESSION["id"];
        $supprimer = $bdd->prepare("DELETE FROM panier WHERE Utilisateur = '$id' "); // On supprime l'ensemble des articles de notre panier.
        $supprimer-> execute();

    // Après l'exécution de notre requête, on revient directement à notre page panier.

        header('location: panier.php');
        exit;

} else
    {
	die("Vous n'avez pas de commandes"); //On prévient l'utilisateur, s'il n'est pas connecté ou bien s'il n'a pas de panier.
        }

} catch(Exception $e){

    die('Erreur:' . $e->getmessage());// On envoi une exception si la connexion n'est pas effectuée.
}
