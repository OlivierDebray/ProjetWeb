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

    <div id="corpus" class="products">
        <p> Les plus Populaires ! </p>
        <p> <?php include('Scripts/DisplayPopularProduct.php') ?></p>
    </div>

    <div id="corpus" class="products">
        <p> Les nouveautés !</p>
        <p> <?php include ('Scripts/DisplayNewProducts.php') ?></p>
    </div>
</body>


    <?php include('includes/footer.php') ?>
</html>

