<?php session_start() ?>

<!DOCTYPE html>

<html lang="fr">
<head>
    <title>Boutique | BDE Exia Orléans</title>
    <meta name="description" content="Parcourez la boutique du BDE pour trouver les goodies de vos rêves !"/>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/boutique.css"/>
    <script src="javascript/manageCart.js"></script>
</head>
<body>
    <?php include ('includes/header.php') ?>
    <?php include('includes/mainNavbar.php') ?>

    <?php include ('includes/shopNavbar.php') ?>

    <h1 class="corpus">Bienvenue sur la Boutique du BDE !</h1>

    <section class="corpus">
        <h2> Les plus Populaires ! </h2>
        <div class="products"> <?php include('scripts/DisplayPopularProduct.php') ?></div>
    </section>


    <section class="corpus">
        <h2> Les nouveautés !</h2>
        <div class="products"> <?php include('scripts/DisplayNewestProduct.php') ?></div>
    </section>

    <?php include('includes/footer.php') ?>
</body>


</html>

