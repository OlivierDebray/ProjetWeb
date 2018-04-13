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
    <table>
        <tr>
            <td>
                <h2>
                    <a href="listeEvenements.php?page=avenir">Evénements à venir</a>
                </h2>
                <p>Découvrez les évenements à venir</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>
                    <a href="listeEvenements.php?page=passes">Evénements passés</a>
                </h2>
                <p>Consultez les événements précédents</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>
                    <a href="boiteAIdee.php">Boite à idées</a>
                </h2>
                <p>Proposez ou votez pour des idées d'activités</p>
            </td>
        </tr>
    </table>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>