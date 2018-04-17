<?php session_start() ?>

<!DOCTYPE html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/categorie.css"/>
    <<link rel="stylesheet" type="text/css" href="css/boutique.css"/>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>
<?php include ('includes/shopNavbar.php')?>

<section id="corpus" >

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

    elseif($_GET['page'] === 't-shirts')
    {
    ?>
        <h1>Boutique de t-shirts</h1>
            <section id="corpus" class="products">

    <?php

       $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
       $query = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'shirt'");
       $query->execute();

    include ('Scripts/AfficherProduit.php');

    ?>
            </section>
    <?php
    }
    elseif($_GET['page'] === 'drapeaux')
    {
    ?>
        <h1> Les Drapeaux !</h1>
            <section id="corpus" class="products">

    <?php

        $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
        $query = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'drapeau'");
        $query->execute();

        include ('Scripts/AfficherProduit.php');

      ?>
            </section>
    <?php

    }
    elseif($_GET['page'] === 'goodies')
    {
        ?>
        <h1> Les Goodies !</h1>
        <section id="corpus" class="products">

            <?php

            $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
            $query = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'goodies'");
            $query->execute();


            include ('Scripts/AfficherProduit.php');

            ?>
        </section>
        <?php
    }
    elseif($_GET['page'] === 'mug') {
    ?>
        <h1> Les Mug !</h1>
            <section id="corpus" class="products">

        <?php
        $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
        $query = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'mug'");
        $query->execute();

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