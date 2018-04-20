<?php
session_start();
try{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb', 'root', ''); //On se connecte à notre base de données.
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e){

	die('Erreur:' . $e->getmessage());//On renvoi une exception si la connection n'a pas pu être effectué.
}


if(isset($_SESSION["id"])) {//On vérifie que l'utilisateur est bien connecté.
	$id= $_SESSION["id"];
	$idP = $_GET['idproduit']; //On récupère l'ID du produit dans l'URL.
	

	$reqpanier= $bdd->prepare("SELECT * FROM panier WHERE Utilisateur = '$id' AND Produit = '$idP'");
	$reqpanier->execute(); //On sélectionne l'ensemble des entrées de la table panier correspondant à l'ID de l'utilisateur connecté et correspondant à l'ID du produit vendu.
		$idP = $_GET['idproduit'];
		$donnée = $reqpanier->fetch();
		do{
	
			if($idP == $donnée['Produit']){
			$incbddpanier = $bdd->prepare("UPDATE panier SET Quantite = Quantite + 1 WHERE Produit = '$idP'");
			$incbddpanier->execute();//On incrémente la quantite du produit ajouté lorsqu'il existe dans la table. 
			
		}

		else if($donnée['Produit']!= $idP){
			$ajoutbddpanier = $bdd->prepare("INSERT INTO panier (Utilisateur, Produit, Quantite) VALUES ( $id, $idP, 1)");
			$ajoutbddpanier->execute(); //On crée une nouvelle entrée lorsque le produit n'existe pas dans la table.
			
		
		}	
	 	
	}while ($donnée = $reqpanier->fetch());
	



		header('location: boutique.php');
	

}


else {
	die("Vous n'êtes pas connecté. Veuillez vous connecter à votre compte pour accéder à votre panier");
}






