<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Panier | BDE Exia Orléans</title>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/panier.css" />
    <script src="javascript/manageCart.js"></script>
</head>

<body>
<?php include ('includes/header.php') ?>
<?php include('includes/mainNavbar.php') ?>
<?php include ('includes/shopNavbar.php') ?>

<?php
if (isset($_SESSION['id'])) {
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
    $id = $_SESSION['id'];
    $query = $bdd->query("SELECT * FROM panier WHERE Utilisateur = '$id'");
    $reponse = $query->fetch();
}
?>


<section id="corpus">
    <?php if (!isset($_SESSION['id'])) { ?>
        <p>Vous devez être <a href="connexion.php">connecté</a> pour accéder au panier !</p>
    <?php } else if (empty($reponse['Utilisateur'])) { ?>
        <h1>Vous n'avez pas d'articles dans votre Panier</h1>
        <a href="boutique.php"> Retourner à la boutique</a>

    <?php }else{
        ?>
        <h1>Voici votre panier !</h1>


        <div class="table">
            <div class="wrap">
                <div class="rowtitle">
                    <span class="image"> </span>
                    <span class= "name"> NomProduit</span>
                    <span class="price"> Prix</span>
                    <span class="Quantity"> Quantite</span>
                    <span class="action"> Supprimer</span>
                </div>
                <?php include('addpanier.php') ?>
            </div>
        </div>

        <span id="button">
            <button class="valide" onclick="window.location.assign('ValiderCommande.php')">Valider votre commande</button>
            <button class="sup" onclick="window.location.assign('AnnulerPanier.php')">Supprimer votre panier</button>
        </span>
    <?php }?>
</section>

<?php include('includes/footer.php') ?>
</body>
</html>
