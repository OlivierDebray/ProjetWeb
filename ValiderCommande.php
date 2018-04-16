<?php session_start() ?>

<!DOCTYPE html>
<html>
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/panier.css" />
</head>

<body>
    <?php include ('includes/header.php') ?>
    <?php include('includes/mainNavbar.php') ?>
    <?php include ('includes/shopNavbar.php') ?>
    <section id="corpus">
        <h1>Veuillez choisir votre mode de paiment</h1>
<button><a href="DemandeRDV.php"> Demander un rendez-vous</a></button>    
<button><a href="Paypal.php"> Paypal</a></button>    

</section>
</body>

<?php include('includes/footer.php') ?>
</html>