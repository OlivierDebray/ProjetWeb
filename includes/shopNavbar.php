<nav id="secondary">
    <?php if (isset($_SESSION['etat']) AND ($_SESSION['etat'] == 1)) { ?>
        <a href="ajoutProduits.php">Ajouter un produit</a>
        <a href="commandes.php">Commandes</a>
    <?php } ?>
</nav>