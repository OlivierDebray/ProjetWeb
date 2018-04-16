<?php session_start() ?>

<!DOCTYPE html>

<html>
    <head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/boutique.css"/>
    </head>
<body>
    <?php include ('includes/header.php') ?>
    <?php include('includes/mainNavbar.php') ?>
    <?php include ('includes/shopNavbar.php') ?>
    <h1 id="corpus">Bienvenue sur la Boutique du BDE !</h1>

    <section id="corpus">
        <h2> Les plus Populaires ! </h2>
        <div class="products"> <?php include('scripts/DisplayPopularProduct.php') ?></div>
    </section>

    <section id="corpus">
        <h2> Les nouveautés !</h2>
        <div class="products"> <?php include('scripts/DisplayNewestProduct.php') ?></div>
    </section>

    <?php include('includes/footer.php') ?>
</body>


</html>

