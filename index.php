<!DOCTYPE html>
<html lang="fr">
<?php include('includes/head.php') ?>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>

<section id="corpus">
    <?php
    if (isset($_GET['page'])) {
        include('pages/mentions.php');
    }
    else {
        include('pages/accueil.php');
    }
    ?>
</section>

<?php include('includes/footer.php') ?>
</body>
</html>
