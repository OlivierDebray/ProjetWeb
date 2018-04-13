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

		$reqpanier = $bdd->prepare(
"SELECT * FROM produits INNER JOIN panier ON produits.ID_Produits = panier.Produit WHERE panier.Utilisateur = '$id'");
		$reqpanier->execute();

	while($donnée = $reqpanier->fetch()){ 
		?>
				<div class= "row">
					<img class="img" src="images/BergerAustralien.jpg" alt="chien" > 
					<span class= "name"><?php echo $donnée['Nom']?></span>
					<span class="price"><?php echo $donnée['Prix']?></span>
					<span class="Quantity"> <?php echo $donnée['Quantite']; ?></span>
					<a href="supprimerpanier.php?id=<?php echo $donnée['Produit']; ?>"><img class= "corb" src="images/corbeille.jpg" alt"sup"></a>
				</div>
		<?php
	}
}
else {
	die("Vous n'avez pas de commandes");
}

?>