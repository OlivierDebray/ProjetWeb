<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/listeEvenements.css"/>
    <script src="javascript/likeEvent.js"></script>
    <script src="javascript/inscription.js"></script>
    <script src="javascript/personnelCesi.js"></script>
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
        if (isset($_GET['page']) AND ($_GET['page'] == "avenir" OR $_GET['page'] == "passes")) {
            $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
            
            // On récupère le statut de l'utilisateur
            $status = $_SESSION['etat'];

            $inscriptionOuverte = false;
            $eventReq = "";

            // Si la page sélectionnée est ...
            switch ($_GET['page']) {
                case "avenir": // ... avenir, on prépare le WHERE pour récupérer les dates ultérieures à aujourd'hui ?>
                    <h1>Evénements à venir</h1>
                    <?php
                    $whereClause = "WHERE Date>'".date("Y-m-d")."'";

                    // Cette variable permettra d'afficher le bouton d'inscription à l'activité
                    $inscriptionOuverte = true;
                    break;
                case "passes": // ... passes, on prépare le WHERE pour récupérer les dates antérieures à aujourd'hui ?>
                    <h1>Evénements passés</h1>
                    <?php
                    $whereClause = "WHERE Date<='".date("Y-m-d")."'";
                    break;
            }

            // On exécute la requête
            $eventReq = $bdd->query("SELECT * FROM evenements ".$whereClause);

            // Pour chacune des entrées de la requête, on affiche les informations de l'événement
            while ($reponse = $eventReq->fetch()) { ?>
                <div class='divEvent'>
                    <h4 class="idEvent">Evénement numéro <?php echo $reponse['ID_Evenements']?></h4>
                    <div class='titreEvent'><h3><?php echo $reponse["Nom"] . "&nbsp;" ?></h3>à <?php echo $reponse["Lieu"] ?></div>
                    <div class="contenuEvent">
                        <img class="imgEvent" id="imgIdee<?php echo $reponse['ID_Evenements']?>" src="images/Suggestionbox<?php echo $reponse['Image'] ?>" alt="Image de l'événement" onclick="downloadImg(<?php echo $reponse['ID_Evenements']?>)"/>
                        <p><?php echo $reponse['Description'] ?></p>
                    </div>
                    <?php // Si l'inscription à l'événement est ouverte
                    if ($inscriptionOuverte) {
                        // On récupère si l'utilisateur est déjà inscrit à l'événement
                        // En fonction, il pourra soit se désinscrire ou s'inscrire à l'événement
                        $participationReq = $bdd->prepare("SELECT COUNT(*) FROM participation WHERE Utilisateur=? AND Evenement=?");
                        $participationReq->execute(array($_SESSION['id'],$reponse['ID_Evenements']));
                        $participation = $participationReq->fetch()[0];
                        $participationReq->closeCursor(); ?>
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
                    <?php if ($_SESSION['etat'] == 2) { ?>
                        <button onclick="supprimerEvenement(<?php echo "'".$_SESSION['nom']." ".$_SESSION['prenom']."',".$reponse['ID_Evenements'] ?>)">Supprimer cet événement et notifier le BDE</button>
                    <?php } ?>
                </div>
            <?php }
        }
    } ?>

</section>

<?php include('includes/footer.php') ?>

</body>
</html>