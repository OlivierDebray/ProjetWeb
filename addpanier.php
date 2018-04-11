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

		$reqpanier = $bdd->prepare("SELECT * FROM test WHERE ID_Utilisateur = '$id'");
		$reqpanier->execute();
echo "test2";
	while($donnée = $reqpanier->fetch()){ 
echo "test1";
		?>
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
					<span class="Quantity"> <?php echo $donnée['quantite']; ?></span>
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