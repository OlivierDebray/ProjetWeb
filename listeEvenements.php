<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Evénements | BDE Exia Orléans</title>
    <meta name="description" content="Découvrez et participez aux événements organisés par le BDE."/>
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
        <p>Vous devez être <a href="connexion.php">connecté</a> pour voir les événements !</p>
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
                    <div class='titreEvent'><h3><?php echo $reponse["Nom"] . "&nbsp;" ?></h3>à <?php echo $reponse["Lieu"] ?> le <?php echo date("d/m/Y", strtotime($reponse['Date'])); ?></div>
                    <div class="contenuEvent">
                        <img class="imgEvent" id="imgIdee<?php echo $reponse['ID_Evenements']?>" src="images/Suggestionbox<?php echo $reponse['Image'] ?>" alt="Image de l'événement" onclick="downloadImg(<?php echo $reponse['ID_Evenements']?>)"/>
                        <p><?php echo $reponse['Description'] ?></p>
                    </div>
                    <?php // Si l'inscription à l'événement est ouverte
                    if ($inscriptionOuverte) {
                        echo "Participation : ".$reponse['Payant'];
                        if ($reponse['Payant'] != "gratuite")
                            echo "€";
                        echo "<br/>";

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
                    <?php }

//------------------------requete pour savoir si l'utilisateur a bien participé à l'évenement------

                        $check = $bdd->prepare('SELECT * FROM participation WHERE Utilisateur = ? AND Evenement = ?');
                        $check->execute(array($_SESSION['id'],$reponse['ID_Evenements']));
                        $check=$check->fetch();
                        if (!empty($check) AND ($_GET['page'] == "passes"))
                        {

//------------------ajout d'un bouton pour aller au formulaire d'ajout de photo---------- ?>
                            <button onclick="window.location.assign('ajoutPhoto.php?numEvent=<?php echo $reponse['ID_Evenements'] ?>')">ajouter une photo</button>
                            <?php
                        }

//----------------Ajout d'un bouton pour telecharger et voir les photos si on est salarié-----------?>

                    <?php if ($_GET['page'] == "passes") { ?>
                        <button onclick="window.location.assign('voirPhoto.php?numEvent=<?php echo $reponse['ID_Evenements'] ?>')">Voir les photos</button>
                    <?php } ?>

                    <?php if ($status == 2 and ($_GET['page'] == "passes")) { ?>
                        <button onclick="window.location.assign('downloadPhotos.php?numEvent=<?php echo $reponse['ID_Evenements'] ?>')">Telecharger les photos</button>
                    <?php }

//------------------------------------------------------------------------------------------

                    if ($_SESSION['etat'] == 2) { ?>
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