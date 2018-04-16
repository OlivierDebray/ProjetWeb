<?php
session_start();
try{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e){

	die('Erreur:' . $e->getmessage());
}


if(isset($_SESSION["id"])) {
	$id= $_SESSION["id"];

	$client = $bdd->query("SELECT * FROM utilisateurs WHERE ID_Utilisateurs=".$id)->fetch();

	$reqpersonne= $bdd->prepare("SELECT * FROM utilisateurs WHERE Status = '1'");
	$reqpersonne->execute();

	while ($donnée = $reqpersonne->fetch()){

		$message = $client['Nom']." ".$client['Prenom']." a commandé sur le site du BDE. Veuillez lui donner un rendez-vous! ";

		$bdd->query("INSERT INTO notifications (FK_ID_Utilisateur, Message) VALUES ( ".$donnée['ID_Utilisateurs'].",'".addslashes($message)."')");

	}


}

else {
	die("Vous n'êtes pas connecté. Veuillez vous connecter à votre compte pour accéder à votre panier");
}
