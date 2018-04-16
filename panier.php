<?php session_start() ?>

<!DOCTYPE html>
<html>
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/panier.css" />
    <script src="javascript/manageCart.js"></script>
</head>

<body>
    <?php include ('includes/header.php') ?>
    <?php include('includes/mainNavbar.php') ?>
    <?php include ('includes/shopNavbar.php') ?>
    <section id="corpus">
        <h1>Voici votre panier !</h1>
    <button><a href="AnnulerPanier.php"> Supprimer votre panier</a></button>    
<div class="table">
        <div class="wrap">
                <div class="rowtitle">
                    <span class="image"> </span>
                    <span class= "name"> NomProduit</span>
                    <span class="price"> Prix</span>
                    <span class="Quantity"> Quantite</span>
                    <span class="action"> Supprimer</span>
                </div>
                <p> <?php include('addpanier.php') ?></p>
            </div>   
        </div> 
    </br>
    <button><a href="ValiderCommande.php"> Valider commande</a></button>

</section>
</body>

<?php include('includes/footer.php') ?>
</html>
