<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/evenements.css"/>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>
<?php include('includes/eventNavbar.php') ?>

<section id="corpus">
    <h1>Bienvenue dans la section événements du BDE !</h1>
    <div class="mainContainer">
        <div class="itemContainer" onclick="window.location.assign('listeEvenements.php?page=avenir')">
            <h2>
                Evénements à venir
            </h2>
            <p>Découvrez les évenements à venir</p>
        </div>
        <div class="itemContainer" onclick="window.location.assign('listeEvenements.php?page=passes')">
            <h2>
                Evénements passés
            </h2>
            <p>Consultez les événements précédents</p>
        </div>
        <div class="itemContainer" onclick="window.location.assign('boiteAIdee.php')">
            <h2>
                Boite à idées
            </h2>
            <p>Proposez ou votez pour des idées d'activités</p>
        </div>
        <?php
        if (isset($_SESSION['etat']) AND ($_SESSION['etat'] == 1)) { ?>
            <div class="itemContainer" onclick="window.location.assign('')">
                <h2>
                    Ajouter un événement
                </h2>
                <p>Ajouter un événement organisé par le BDE</p>
            </div>
        <?php }
        ?>
    </div>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>