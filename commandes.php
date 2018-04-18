<?php session_start();

if (isset($_GET['id'])) {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb;charset=utf8', 'root', '');

    $bdd->query("UPDATE commande SET Etat=1 WHERE ID_Commande=".$_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <script src="javascript/changeCommandeState.js"></script>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>
<?php include('includes/shopNavbar.php') ?>

<section id="corpus">
    <div id="commandesEnCours">
        <?php if (isset($_SESSION['id']) AND $_SESSION['etat'] == 1) {
        $bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb;charset=utf8', 'root', ''); ?>
        <h1>Affichage des commandes en cours</h1>
        <?php
        $commandeCours = $bdd->query("SELECT * FROM commande WHERE Etat=0");
        while ($commande = $commandeCours->fetch()) {
            $user = $bdd->query("SELECT * FROM utilisateurs WHERE ID_Utilisateurs=".$commande['Utilisateur'])->fetch();
            $product = $bdd->query("SELECT * FROM produits WHERE ID_Produits=".$commande['Produit'])->fetch();
            echo "<p id='para".$commande['ID_Commande']."'>";
            echo $commande['Date']." | ";
            echo $user['Nom']." ".$user['Prenom']." | ";
            echo $product['Nom']." x ".$commande['Quantite']." ";
            echo "<button id='button".$commande['ID_Commande']."' onclick='changeCommandeState(".$commande['ID_Commande'].")'>Marquer cette commande comme livrée</button>";
            echo "</p>";
        }
        ?>
    </div>
    <div id="commandesLivrees">
        <h1>Affichage des commandes livrées</h1>
        <?php
        $commandeCours = $bdd->query("SELECT * FROM commande WHERE Etat=1");
        while ($commande = $commandeCours->fetch()) {
            $user = $bdd->query("SELECT * FROM utilisateurs WHERE ID_Utilisateurs=".$commande['Utilisateur'])->fetch();
            $product = $bdd->query("SELECT * FROM produits WHERE ID_Produits=".$commande['Produit'])->fetch();
            echo "<p>";
            echo $commande['Date']." | ";
            echo $user['Nom']." ".$user['Prenom']." | ";
            echo $product['Nom']." x ".$commande['Quantite'];
            echo "</p>";
        }
        } else {
            echo "Vous devez être connecté et membre du BDE pour voir cette page !";
        }?>
    </div>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>
