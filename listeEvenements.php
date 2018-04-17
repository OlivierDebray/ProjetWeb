<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/listeEvenements.css"/>
    <script src="javascript/likeEvent.js"></script>
    <script src="javascript/inscription.js"></script>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>
<?php include('includes/eventNavbar.php') ?>

<section id="corpus">
    <?php if (!isset($_SESSION['id'])) { ?>
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

            $inscriptionOuverte = false;
            $eventReq = "";

            switch ($_GET['page']) {
                case "avenir": ?>
                    <h1>Evénements à venir</h1>
                    <?php $eventReq = $bdd->query("SELECT * FROM evenements WHERE Etat = 1");
                    $inscriptionOuverte = true;
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
                        <img class="imgEvent" id="imgIdee<?php echo $reponse['ID_Evenements']?>" src="images/Suggestionbox<?php echo $reponse['Image'] ?>" alt="Image de l'événement" onclick="downloadImg(<?php echo $reponse['ID_Evenements']?>)"/>
                        <p><?php echo $reponse['Description'] ?></p>
                    </div>
                    <?php $participationReq = $bdd->prepare("SELECT COUNT(*) FROM participation WHERE Utilisateur=? AND Evenement=?");
                    $participationReq->execute(array($_SESSION['id'],$reponse['ID_Evenements']));
                    $participation = $participationReq->fetch()[0];
                    $participationReq->closeCursor();
                    if ($inscriptionOuverte) { ?>
                        <button id="button<?php echo $reponse['ID_Evenements'] ?>"
                                onclick="inscription(<?php echo $_SESSION['id'] . "," . $reponse['ID_Evenements'] . "," . $participation ?>)">
                            <?php if ($participation == 0) { ?>
                                S'inscrire
                            <?php } else if ($participation == 1) { ?>
                                Se désinscrire
                            <?php } ?>
                        </button>
                    <?php }
                    // Si l'utilisateur est membre du BDE, il peut accéder à la liste des participants
                    if ($status == 1) { ?>
                        <button onclick="window.location.assign('scripts/exportPDF.php?listParticipant=<?php echo $reponse['ID_Evenements'] ?>')">Liste des participants</button>
                    <?php } ?>
                    <div class="userAction">
                        <?php $likeReq = $bdd->prepare("SELECT COUNT(*) FROM `action` WHERE Evenement=? AND `Like`=1");
                        $likeReq->execute(array($reponse['ID_Evenements']));
                        $likes = $likeReq->fetch();

                        $userLikeReq = $bdd->prepare("SELECT COUNT(*) FROM `action` WHERE Utilisateur=? AND Evenement=? AND `Like`=1");
                        $userLikeReq->execute(array($_SESSION['id'],$reponse['ID_Evenements']));
                        $usersLike = $userLikeReq->fetch();

                        echo "<img id='img".$reponse['ID_Evenements']."' src='images/thumb%20up.png' ";
                        echo "onclick='likeEvent(".$_SESSION['id'].",".$reponse['ID_Evenements'].",".$likes['COUNT(*)'].",".$usersLike['COUNT(*)'].",\"event\")' ";
                        echo "alt='Liker' />";
                        echo "<label id='like" . $reponse['ID_Evenements'] . "'>" . $likes['COUNT(*)'] . " like(s)</label>";
                        $likeReq->closeCursor();
                        $userLikeReq->closeCursor(); ?>
                    </div>
                </div>
            <?php }
        }
    } ?>

</section>

<?php include('includes/footer.php') ?>

</body>
</html>