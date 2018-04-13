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
	$idP = $_GET['idproduit'];
	

	$reqpanier= $bdd->prepare("SELECT * FROM panier WHERE Utilisateur = '$id' AND Produit = '$idP'");
	$reqpanier->execute();

		$idP = $_GET['idproduit'];
		$donnée = $reqpanier->fetch();
		do{
	
			if($idP == $donnée['Produit']){
			$incbddpanier = $bdd->prepare("UPDATE panier SET Quantite = Quantite + 1 WHERE Produit = '$idP'");
			$incbddpanier->execute();
			print_r($donnée); echo 'test1';
		}

		else if($donnée['Produit']!= $idP){
			$ajoutbddpanier = $bdd->prepare("INSERT INTO panier (Utilisateur, Produit, Quantite) VALUES ( $id, $idP, 1)");
			$ajoutbddpanier->execute();
			print_r($donnée); echo 'test2';
		
		}	
	 	
	}while ($donnée = $reqpanier->fetch());
	



		//header('location: boutique.php');
	

}


else {
	die("Vous n'êtes pas connecté. Veuillez vous connecter à votre compte pour accéder à votre panier");
}






