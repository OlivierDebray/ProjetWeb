<?php session_start() ?>

<!DOCTYPE html>

<html lang="fr">
<head>
    <title>Recherche | BDE Exia Orléans</title>
    <meta name="description" content="Recherchez un produit en particulier dans notre boutique."/>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/boutique.css"/>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css"/>
    <script src="javascript/jquery-3.3.1.min.js"></script>
    <script src="javascript/jquery-ui.js"></script>
    <script src="javascript/manageCart.js"></script>

    <script>
        //Appel du script d'autocompletion de JqueryUi avec une source distante
        $(function() {
            $( "#recherche" ).autocomplete({
                source: 'Scripts/liste.php'
            });
        });
    </script>

</head>

<body>
<?php include ('includes/header.php')?>
<?php include('includes/mainNavbar.php') ?>
<?php include ('includes/shopNavbar.php') ?>




<h1 class="corpus">Rechercher un Produit.</h1>
<div class="corpus">
    <form method="GET">

        <label>Tapez le nom d'un produit</label>
        <input id="recherche" type="search" name="q" placeholder="Recherche"/>

        <input type="radio" id="critere1" name="prix" value="ASC">
            <label for="critere1">Prix croissant</label>

        <input type="radio" id="critere2" name="prix" value="DESC">
            <label for="critere1">Prix décroissant</label>

        <input type="submit" value="Valider"/>
    </form>

</div>

<div class="corpus">
    <div class="products">
        <?php include ('Scripts/outilRecherche.php');?>
    </div>
</div>
</body>

</html>