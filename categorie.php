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
       $shirtReq = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'shirt'");
       $shirtReq->execute();

    while ($reponse = $shirtReq->fetch())
    {
        ?>
            <div class="product">
                <div class='name'> <?php echo $reponse['Nom']?></div>

                <img src='images/produits/<?php echo $reponse['url']?>', class='imgprod' />


                <div class='price'>Prix : <?php echo $reponse['Prix']?></div>

                <div class='description'> Description : <?php echo $reponse['Description']?></div>
                <a href=''> <button> Ajouter au Panier </button></a>
        </div>


        <?php
    }

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
        $flagReq = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'drapeau'");
        $flagReq->execute();

    while ($reponse = $flagReq->fetch())
    {
     ?>
        <div class="product">
            <div class='name'> <?php echo $reponse['Nom'] ?></div>
            <img src='images/produits/<?php echo $reponse['url'] ?>' , class='imgprod'/>
            <div class='price'>Prix : <?php echo $reponse['Prix'] ?></div>
            <div class='description'> Description : <?php echo $reponse['Description'] ?></div>
            <a href=''><button> Ajouter au Panier</button></a>
        </div>

        <?php
    }
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
            $goodReq = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'goodies'");
            $goodReq->execute();


            while ($reponse = $goodReq->fetch())
            {
                ?>

                <div class="product">
                    <div class='name'> <?php echo $reponse['Nom'] ?></div>
                    <img src='images/produits/<?php echo $reponse['url'] ?>' , class='imgprod'/>
                    <div class='price'>Prix : <?php echo $reponse['Prix'] ?></div>
                    <div class='description'> Description : <?php echo $reponse['Description'] ?></div>
                    <a href=''>
                        <button> Ajouter au Panier</button>
                    </a>

                </div>

                <?php
            }
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
        $mugReq = $bdd->prepare("SELECT * FROM produits WHERE Categorie = 'mug'");
        $mugReq->execute();

        while ($reponse = $mugReq->fetch()){
            ?>

                <div class="product">
                    <div class='name'> <?php echo $reponse['Nom'] ?></div>
                    <img src='images/produits/<?php echo $reponse['url'] ?>' , class='imgprod'/>
                    <div class='price'>Prix : <?php echo $reponse['Prix'] ?></div>
                    <div class='description'> Description : <?php echo $reponse['Description'] ?></div>
                    <a href=''>
                        <button> Ajouter au Panier</button>
                    </a>

                </div>
                <?php
        }
        ?>
            </section>
    <?php

    }
    ?>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>