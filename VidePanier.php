<?php session_start();

try{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e){

	die('Erreur:' . $e->getmessage());
}

if(isset($_SESSION["id"])) {
	$id= $_SESSION["id"];

	$bdd->query("DELETE FROM panier WHERE Utilisateur = '$id'");
}

?>