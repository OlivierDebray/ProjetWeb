<?php
session_start();
try{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '');
}

catch(Exception $e){

	die('Erreur:' . $e->getmessage());
}


if(isset($_SESSION["id"])) {
	$id= $_SESSION["id"];

		$reqpanier = $bdd->prepare('SELECT * FROM panier WHERE ID_Utilisateur = $id');
		$reqpanier->execute();

	while($donnée = $reqpanier->fletch()){ ?>
		<div class="table">
			<div class="wrap">
				<div class="rowtitle">
					<span class="image"> </span>
					<span class= "name"> NomProduit</span>
					<span class="price"> Prix</span>
					<span class="Quantity"> Quantite</span>
					<span class="action"> Supprimer</span>
				</div>

				<div class= "row">
					<img class="img" src="images/BergerAustralien.jpg" alt="chien" > 
					<span class= "name"> Berger Australien</span>
					<span class="price"> 1000 €</span>
					<span class="Quantity"> 1</span>
					<span class="action"> Supprimer</span>
				</div>
			</div>   
		</div> 
		<?php
	}
}
else {
	
}

?>