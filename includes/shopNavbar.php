<nav id="secondary">
    <a href="categorie.php">Categories</a>
    <a href="recherche.php">Recherche</a>
    <a href="panier.php"> Panier</a>
    <?php if (isset($_SESSION['etat']) AND ($_SESSION['etat'] == 1)) { ?>
        <a href="ajoutProduits.php">Ajouter un produit</a>
    <?php } ?>
</nav>