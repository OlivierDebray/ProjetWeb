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
                    <a href="">Activités</a>
                </h2>
                <p>Découvrez les activités proposées par les étudiants</p>
            </td>
            <td>
                <h2>
                    <a href="">Manifestations du BDE</a>
                </h2>
                <p>Découvrez les manifestations organisées par le BDE</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>
                    <a href="">Boite à idées</a>
                </h2>
                <p>Proposez ou votez pour des idées d'activités</p>
            </td>
            <td>
                <h2>
                    <a href="">Evénements passés</a>
                </h2>
                <p>Consultez les événements précédents</p>
            </td>
        </tr>
    </table>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>