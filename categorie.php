<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Catégories | BDE Exia Orléans</title>
    <meta name="description" content="Explorez les différentes catégories de notre boutique !"/>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/categorie.css"/>
    <link rel="stylesheet" type="text/css" href="css/boutique.css"/>
    <link rel="stylesheet" type="text/css" href="css/evenements.css"/>
    <script src="javascript/manageCart.js"></script>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>
<?php include ('includes/shopNavbar.php')?>

<section id="corpus">
    <?php
    if (!isset($_GET['page'])) {
        ?>

        <h1>Bienvenue sur les catégories de la boutique</h1>
        <div class="mainContainer">
            <div class="itemContainer" onclick="window.location.assign('categorie.php?page=t-shirts')">
                <h2>
                    T-Shirts
                </h2>
                <p>Portez les couleurs de l'école !</p>
            </div>
            <div class="itemContainer" onclick="window.location.assign('categorie.php?page=drapeaux')">
                <h2>
                    Drapeaux
                </h2>
                <p>Brandissez les !</p>
            </div>
            <div class="itemContainer" onclick="window.location.assign('categorie.php?page=goodies')">
                <h2>
                    Goodies
                </h2>
                <p>Bracelets, bonbons, balles rebondissantes !</p>
            </div>
            <div class="itemContainer" onclick="window.location.assign('categorie.php?page=mug')">
                <h2>
                    Mugs
                </h2>
                <p>Les Mugs!</p>
            </div>
            <?php if (isset($_SESSION['etat']) AND ($_SESSION['etat'] == 1)) { ?>
                <div class="itemContainer" onclick="window.location.assign('ajoutProduits.php')">
                    <h2>
                        [BDE] Ajouter un produit
                    </h2>
                </div>
            <?php } ?>
        </div>
        <?php
    }
    // Si la page possède la valeur t-shirts on affiche seulement les articles de la catégorie shirt
    elseif($_GET['page'] === 't-shirts')
    {
    ?>
        <h1>Boutique de t-shirts</h1>
            <section class="products">

    <?php
        // on ouvre une connexion à la base de données puis on cherche tous les produits de la catégorie 'shirt'
       $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
       $query = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'shirt'");
       $query->execute();

    // On appelle le script AfficherProduit qui permet d'afficher les articles
    include ('Scripts/AfficherProduit.php');

    ?>
            </section>
    <?php
    }

    // Si la page possède la valeur drapeaux on affiche seulement les articles de la catégorie drapeau
    elseif($_GET['page'] === 'drapeaux')
    {
    ?>
        <h1> Les Drapeaux !</h1>
            <section  class="products">

    <?php

    //on ouvre une connexion à la base de données puis on cherche tous les produits de la catégorie 'drapeau'
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
        $query = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'drapeau'");
        $query->execute();

        // On appelle le script AfficherProduit qui permet d'afficher les articles
        include ('Scripts/AfficherProduit.php');

      ?>
            </section>
    <?php
    }

    // Si la page possède la valeur goodies on affiche seulement les articles de la catégorie goodies
    elseif($_GET['page'] === 'goodies')
    {
        ?>
        <h1> Les Goodies !</h1>
        <section class="products">

            <?php

            //on ouvre une connexion à la base de données puis on cherche tous les produits de la catégorie 'goodies'
            $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
            $query = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'goodies'");
            $query->execute();

            // On appelle le script AfficherProduit qui permet d'afficher les articles
            include ('Scripts/AfficherProduit.php');

            ?>
        </section>
        <?php
    }

    // Si la page possède la valeur mug on affiche seulement les articles de la catégorie mug
    elseif($_GET['page'] === 'mug') {
    ?>
        <h1> Les Mug !</h1>
            <section class="products">

        <?php

        //on ouvre une connexion à la base de données puis on cherche tous les produits de la catégorie 'mug'
        $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
        $query = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'mug'");
        $query->execute();

        // On appelle le script AfficherProduit qui permet d'afficher les articles
        include ('Scripts/AfficherProduit.php');

        ?>
            </section>
    <?php

    }
    ?>
</section>

<?php include('includes/footer.php') ?>

</body>


</html>