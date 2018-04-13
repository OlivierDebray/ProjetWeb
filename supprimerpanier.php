<?php
session_start();
try{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e){

	die('Erreur:' . $e->getmessage());
}

if(isset($_SESSION["id"])) {
	$id= $_SESSION["id"];

$idP=$_GET['id'];

$supprimer = $bdd->prepare("DELETE FROM panier WHERE Produit = '$idP'");
$supprimer-> execute();

header('location: panier.php');

}

else {
	die("Vous n'avez pas de commandes");
}

?>