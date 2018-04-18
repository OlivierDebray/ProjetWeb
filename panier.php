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
        <?php if (!isset($_SESSION['id'])) { ?>
        <p>Vous devez être connecté pour voir les événements !</p>
        <?php } else{ ?>
        <h1>Voici votre panier !</h1>

        <button onclick="window.location.assign('AnnulerPanier.php')">Supprimer votre panier</button>

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
    <?php }?>

    <button onclick="window.location.assign('ValiderCommande.php')">Valider votre commande</button>
</section>
</body>

<?php include('includes/footer.php') ?>
</html>
