<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/listeEvenements.css"/>
    <script src="javascript/likeEvent.js"></script>
    <script src="javascript/personnelCesi.js"></script>
    <script src="javascript/manageComment.js"></script>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>
<?php include('includes/eventNavbar.php') ?>

<section id="corpus">
    <h1>Voir les photos de l'événement</h1>

    <?php
    /*
     * On récupère toutes les données correspondant à l'évènement défini
     */
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb;charset=utf8', 'root', '');
    $query=$bdd->prepare("SELECT * FROM image WHERE Evenement = ?");
    $query->execute(array($_GET['numEvent']));

    //On parcourt toutes les images
    while ($reponse = $query->fetch())
    { ?>
        <div class="divPhoto">
            <img src='images/photosEvenement/<?php echo $_GET['numEvent']?>/<?php echo $reponse['url']?>' class='imgprod' alt="image" />
            <div class='product'>
                <?php if ($_SESSION['etat'] != 0) {
                    echo "<button onclick=\"window.location.assign('downloadPicture.php?numImage=".$reponse['ID_Image']."')\">Telecharger</button>";
                }
                ?>
                <?php if ($_SESSION['etat'] == 1) {
                    echo "<button onclick='supprimerImage(\"\",".$reponse['ID_Image'].")'>Supprimer la photo</button>";
                }
                else if ($_SESSION['etat'] == 2) {
                    echo "<button onclick='supprimerImage(\"".$_SESSION['nom']." ".$_SESSION['prenom']."\",".$reponse['ID_Image'].")'>Supprimer la photo et notifier le BDE</button>";
                }
                ?>
            </div>
            <div class="userAction">
                <?php

                /*
                 * On récupère tout les likes d'une image définie
                 * On récupère tout les likes d'un utilisateur, pour une image définie
                 */
                $likeReq = $bdd->prepare("SELECT COUNT(*) FROM `action` WHERE Image=? AND `Like`=1");
                $likeReq->execute(array($reponse['ID_Image']));
                $likes = $likeReq->fetch();

                $userLikeReq = $bdd->prepare("SELECT COUNT(*) FROM `action` WHERE Utilisateur=? AND Image=? AND `Like`=1");
                $userLikeReq->execute(array($_SESSION['id'],$reponse['ID_Image']));
                $usersLike = $userLikeReq->fetch();

                echo "<img id='img".$reponse['ID_Image']."' src='images/thumb%20up.png' ";
                echo "onclick='likeEvent(".$_SESSION['id'].",".$reponse['ID_Image'].",".$likes['COUNT(*)'].",".$usersLike['COUNT(*)'].",\"event\")' ";
                echo "alt='Liker' />";
                echo "<label id='like" . $reponse['ID_Image'] . "'>" . $likes['COUNT(*)'] . " like(s)</label>";
                $likeReq->closeCursor();
                $userLikeReq->closeCursor(); ?>
            </div>
            <h3>Commentaires:</h3>
            <textarea id="textarea<?php echo $reponse['ID_Image'] ?>" class="commentaire" placeholder="Votre commentaire..." maxlength="255"></textarea>
            <button id="button<?php echo $reponse['ID_Image'] ?>" onclick="addComment(<?php echo $reponse['ID_Image'].",".$_SESSION['id'] ?>)">Poster mon commentaire</button>
            <?php
            // On récupère les commentaires d'une image
            $commentaire2 = $bdd->prepare('SELECT * FROM action WHERE Image = ? AND Commentaire IS NOT NULL');
            $commentaire2->execute(array($reponse['ID_Image']));

            echo "<div id='commentContainer".$reponse['ID_Image']."'>";
            /*
             * Lecture de tout les commentaires
             * Affichage des commentaires, par utilisateur
             */
            while ($c = $commentaire2->fetch())
            {
                $currentUser = $bdd->query("SELECT * FROM utilisateurs WHERE ID_Utilisateurs=".$c['Utilisateur'])->fetch();
                echo "<p class='comment'>";
                echo "<strong>".$currentUser['Prenom']." ".$currentUser['Nom']." a dit :</strong><br/>";
                echo $c['Commentaire'];

                /*
                 * Si l'utilisateur est un membre du BDE ou un personnel du CESI
                 * On permet la suppresion du commentaire, avec des distinctions
                 */
                if (($c['Utilisateur'] == $_SESSION['id']) OR ($_SESSION['etat'] == 1))
                    echo "<br/><button onclick='deleteComment(".$reponse['ID_Image'].",".$c['Utilisateur'].")'>Supprimer le commentaire</button>";
                else if ($_SESSION['etat'] == 2)
                    echo "<br/><button onclick='supprimerCommentaire(\"".$_SESSION['nom']." ".$_SESSION['prenom']."\",".$reponse['ID_Image'].",\"".$currentUser['Prenom']." ".$currentUser['Nom']."\",".$c['Utilisateur'].")'>Supprimer le commentaire</button>";
                echo "</p>";
            }
            echo "</div>"; ?>
        </div>
    <?php }
    ?>

</section>

<?php include('includes/footer.php') ?>

</body>
</html>


