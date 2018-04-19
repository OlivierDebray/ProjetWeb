<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/categorie.css"/>
    <link rel="stylesheet" type="text/css" href="css/boutique.css"/>
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
        <table>
            <tr>
                <td>
                    <h2>
                        <a href="?page=t-shirts">T-Shirt</a>
                    </h2>
                    <p>Portez les couleurs de l'école !</p>
                </td>
                <td>
                    <h2>
                        <a href="?page=drapeaux">Drapeaux</a>
                    </h2>
                    <p>Brandissez les !</p>
                </td>
            </tr>
            <tr>
                <td>
                    <h2>
                        <a href="?page=goodies">Goodies</a>
                    </h2>
                    <p>Bracelets, bonbons, balles rebondissante !</p>
                </td>
                <td>
                    <h2>
                        <a href="?page=mug">Mugs</a>
                    </h2>
                    <p>Les Mugs!</p>
                </td>
            </tr>
        </table>
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