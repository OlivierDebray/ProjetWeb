<?php session_start() ?>

<!DOCTYPE html>

<html>
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/pageProduit.css"/>

</head>

<body>
<?php include ('includes/header.php')?>
<?php include('includes/mainNavbar.php') ?>
<?php include ('includes/shopNavbar.php') ?>

<section id="corpus">
        <?php
        $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root','');

        if (isset($_GET['produit']) AND !empty($_GET['produit'])){
            $id = htmlspecialchars($_GET['produit']);

            $query = $bdd->prepare('SELECT * FROM produits WHERE ID_Produits = '.$id.' ');
            $query->execute();


        while ($reponse = $query->fetch())
        {?>
            <div class='product'>


                <div class="left-column">
                    <img src='images/produits/<?php echo $reponse['url']?>' class='imgprod' alt="image" />
                </div>

                <div class='right-column'>
                    <span> Catégorie : <?php echo $reponse['Categorie'];?></span>
                    <h1><?php echo $reponse['Nom']?></h1>
                    <p>Description : <?php echo$reponse['Description']?></p>
                </div>


                <div class='price'>

                    <p>Stock restant: <?php echo $reponse['Stock'];?></p>
                    <span> Prix: <?php echo $reponse['Prix']?>$</span>

                    <button onclick="addToCart(<?php echo $reponse['ID_Produits']; ?>)">Ajouter au panier </button>
                </div>

            </div>

                <?php }

                }
        ?>


</section>


<?php include('includes/footer.php') ?>
</body>


</html>
