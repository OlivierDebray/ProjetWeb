<?php session_start() ?>

<!DOCTYPE html>

<html>
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
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

                <img src='images/produits/<?php echo $reponse['url']?>' class='imgprod' alt="image" />

                <div class='name'> <?php echo $reponse['Nom']?></div>

                <div class='price'> Prix: <?php echo $reponse['Prix']?>$</div>

                <div class="categorie"> Catégorie : <?php echo $reponse['Categorie'];?></div>

                <div class="stock"> Stock restant: <?php echo $reponse['Stock'];?></div>

                <div class='description'> Description : <?php echo$reponse['Description']?></div>

                <button onclick="addToCart(<?php echo $reponse['ID_Produits']; ?>)">Ajouter au
                    panier
                </button>
            </div>

                <?php }

                }
        ?>


</section>


<?php include('includes/footer.php') ?>
</body>


</html>
