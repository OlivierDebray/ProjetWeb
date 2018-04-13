<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/listeEvenements.css"/>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>
<?php include('includes/eventNavbar.php') ?>

<section id="corpus">
    <?php
    if (!isset($_SESSION['id'])) { ?>
        <p>Vous devez être connecté pour voir les événements !</p>
    <?php }
    else {
        if (isset($_GET['page'])) {
            $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

            $req = $bdd->prepare("SELECT Status FROM utilisateurs WHERE ID_Utilisateurs=?");
            $req->execute(array($_SESSION['id']));
            $status = $req->fetch();
            $req->closeCursor();
            $status = $status['Status'];

            $eventReq = "";

            switch ($_GET['page']) {
                case "avenir": ?>
                    <h1>Evénements à venir</h1>
                    <?php $eventReq = $bdd->query("SELECT * FROM evenements WHERE Etat = 1");
                    break;
                case "passes": ?>
                    <h1>Evénements passés</h1>
                    <?php $eventReq = $bdd->query("SELECT * FROM evenements WHERE Etat = 2");
                    break;
            }

            while ($reponse = $eventReq->fetch()) { ?>
                <div class='divEvent'>
                    <h4 class="idEvent">Evénement numéro <?php echo $reponse['ID_Evenements']?></h4>
                    <div class='titreEvent'><h3><?php echo $reponse["Nom"] . "&nbsp;" ?></h3>à <?php echo $reponse["Lieu"] ?></div>
                    <div class="contenuEvent">
                        <img class="imgEvent" src="images/Suggestionbox<?php echo $reponse['Image'] ?>" alt="Image de l'événement" />
                        <p><?php echo $reponse['Description'] ?></p>
                    </div>
                </div>
                <?php
            }
            ?>

            <?php
        }
    }
    ?>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>