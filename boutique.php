<?php session_start() ?>

<!DOCTYPE html>

<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/boutique.css"/>
    <script src="javascript/manageCart.js"></script>
</head>
<body>
    <!-- HEADER -->
    <?php include ('includes/header.php') ?>
    <!-- MAIN NAV BAR -->
    <?php include('includes/mainNavbar.php') ?>

    <!-- SHOP NAV BAR -->
    <?php include ('includes/shopNavbar.php') ?>

    <h1 class="corpus">Bienvenue sur la Boutique du BDE !</h1>

    <!-- Affiche les articles populaires -->
    <section class="corpus">
        <h2> Les plus Populaires ! </h2>
        <div class="products"> <?php include('scripts/DisplayPopularProduct.php') ?></div>
    </section>

    <!-- Affiche les articles récents -->

    <section class="corpus">
        <h2> Les nouveautés !</h2>
        <div class="products"> <?php include('scripts/DisplayNewestProduct.php') ?></div>
    </section>

    <!-- FOOTER -->
    <?php include('includes/footer.php') ?>
</body>


</html>

