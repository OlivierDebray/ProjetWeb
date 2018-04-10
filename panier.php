<!DOCTYPE.html>
<html>
    <?php include('includes/head.php') ?>

<body>
    <?php include ('includes/header.php')?>
    <?php include('includes/mainNavbar.php') ?>
    <?php include ('includes/shopNavbar.php') ?>
    <section id="corpus">
    <h1>Voici votre panier !</h1>
<div class="table">
    	<div class="rowtitle">
    		<span class= "name"> NomProduit</span>
    		<span class="price"> Prix</span>
    		<span class="Quantity"> Quantite</span>
    		<span class="action"> Supprimer</span>
    	</div>

        <div class= "row">
            <img class="img" src="images\BergerAustralien.jpg" alt="chien">
            <span class= "name"> Berger Australien</span>
            <span class="price"> 1000 €</span>
            <span class="Quantity"> 1</span>
            <span class="action"> Supprimer</span>
        </div>
</div>  
    </section>
</body>

    <?php include('includes/footer.php') ?>
</html>
