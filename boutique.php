<?php session_start() ?>

<!DOCTYPE html>

<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/boutique.css"/>
    <script src="javascript/manageCart.js"></script>
</head>
<body>
    <?php include ('includes/header.php') ?>
    <?php include('includes/mainNavbar.php') ?>

    <?php include ('includes/shopNavbar.php') ?>

    <h1 class="corpus">Bienvenue sur la Boutique du BDE !</h1>

<<<<<<< HEAD
    <!-- Affiche les articles populaires -->
    <section class="corpus">
=======
    <section id="corpus">
>>>>>>> origin/shop
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

