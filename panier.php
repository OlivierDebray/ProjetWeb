<!DOCTYPE.html>
<html>
    <?php include('includes/head.php') ?>

<body>
    <?php include ('includes/header.php')?>
    <?php include('includes/mainNavbar.php') ?>
    <?php include ('includes/shopNavbar.php') ?>
    <h1>Voici votre panier !</h1>
<div class="table">
    	<div class="rowtitle">
    		<span class= "name"> NomProduit</span>
    		<span class="price"> Prix</span>
    		<span class="Quantity"> Quantite</span>
    		<span class="action"> Supprimer</span>
    	</div>

        <div class= "row">
            <a href="#" class= "img"><img src="images\BergerAustralien.jpg"></a>
            <span class= "name"> Berger Australien</span>
            <span class="price"> 1000 €</span>
            <span class="Quantity"> 1</span>
            <span class="action"> Supprimer</span>
        </div>
</div>
</body>

    <?php include('includes/footer.php') ?>
</html>
