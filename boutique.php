<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/html">
    <head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/boutique.css"/>
    </head>
<body>
    <?php include ('includes/header.php')?>
    <?php include('includes/mainNavbar.php') ?>
    <?php include ('includes/shopNavbar.php') ?>
    <h1 id="corpus">Bienvenue sur la Boutique du BDE !</h1>

    <div id="corpus" class="products" >
        <h2> Les plus Populaires ! </h2>
        <p> <?php include('scripts/DisplayPopularProduct.php') ?></p>
    </div>

    <div id="corpus" class="products">
        <p> Les nouveautés !</p>
        <p> <?php include('scripts/DisplayNewProducts.php') ?></p>
    </div>
</body>


    <?php include('includes/footer.php') ?>
</html>

