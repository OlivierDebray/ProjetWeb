<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>

<section id="corpus">
    <?php // Si on a spécifié une page particulière à afficher, on l'affiche (telle les mentions légales)
    if (isset($_GET['page'])) {
        include('pages/' . $_GET['page'] . '.php');
    }
    else { // Sinon, on affiche la page d'accueil
        include('pages/accueil.php');
    }
    ?>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>