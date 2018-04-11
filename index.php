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
    <?php
    if (isset($_GET['page'])) {
        include('pages/' . $_GET['page'] . '.php');
    }
    else {
        include('pages/accueil.php');
    }
    ?>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>