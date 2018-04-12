<?php session_start() ?>

<!DOCTYPE html>

<html>
    <head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/boutique.css"/>
    </head>
<body>
    <?php include ('includes/header.php')?>
    <?php include('includes/mainNavbar.php') ?>
    <?php include ('includes/shopNavbar.php') ?>
    <h1 id="corpus">Bienvenue sur la Boutique du BDE !</h1>

    <section id="corpus" class="products" >
        <h2> Les plus Populaires ! </h2>
        <p> <?php include('scripts/DisplayPopularProduct.php') ?></p>
    </section>

    <section id="corpus" class="products">
        <p> Les nouveautés !</p>
        <p> <?php include('scripts/DisplayNewProducts.php') ?></p>
    </section>

    <?php include('includes/footer.php') ?>
</body>


</html>

