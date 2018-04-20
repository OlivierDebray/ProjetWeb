<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Boite à idée | BDE Exia Orléans</title>
    <meta name="description" content="Proposez vos idées pour le BDE."/>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/boiteAIdee.css"/>
    <script src="javascript/likeEvent.js"></script>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>
<?php include('includes/eventNavbar.php') ?>

<section id="corpus">
    <?php // Si l'utilisateur n'est pas connecté, on n'affiche pas les informations de la boite à idée
    if (!isset($_SESSION['id'])) { ?>
        <h1>Boite à idée</h1>
        <p>Vous devez être <a href="connexion.php">connecté</a> pour voir la boite à idée et y contribuer !</p>
    <?php }
    // Autrement ...
    else {
        // Si il n'y a pas de page spécifié en GET, on affiche la boite à idée
        if (!isset($_GET['page'])) {
            $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', ''); ?>

            <div id="title">
                <h1>Boite à idées</h1>
                <button onclick="window.location.assign('?page=submit')">Proposer une idée</button>
            </div>

            <?php
            $ideeReq = $bdd->prepare("SELECT * FROM evenements WHERE Etat = ?");
            $ideeReq->execute(array("0"));

            // Boucle permettant d'afficher chacune des idées dans la base de données
            while ($reponse = $ideeReq->fetch()) { ?>
                <div class='divIdee'>
                    <h4 class='idIdee'>Idée numéro <?php echo $reponse['ID_Evenements']?></h4>
                    <div class='titreIdee'><h3><?php echo $reponse["Nom"] . "&nbsp;" ?></h3>à <?php echo $reponse["Lieu"] ?></div>
                    <div class="contenuEvent">
                        <img class="imgIdee" id="imgIdee<?php echo $reponse['ID_Evenements']?>" src="images/Suggestionbox<?php echo $reponse['Image'] ?>" alt="Image de l'idée" onclick="downloadImg(<?php echo $reponse['ID_Evenements']?>)"/>
                        <p><?php echo $reponse['Description'] ?></p>
                    </div>
                    <div class="userAction">
                        <?php // On récupère tout d'abord le nombre total de likes pour l'idée étudiée
                        $likeReq = $bdd->prepare("SELECT COUNT(*) FROM vote WHERE Evenement=?");
                        $likeReq->execute(array($reponse['ID_Evenements']));
                        $likes = $likeReq->fetch();

                        // On récupère ensuite si l'utilisateur a déjà voté pour cette idée
                        $userLikeReq = $bdd->prepare("SELECT COUNT(*) FROM vote WHERE Utilisateur=? AND Evenement=?");
                        $userLikeReq->execute(array($_SESSION['id'],$reponse['ID_Evenements']));
                        $usersLike = $userLikeReq->fetch();

                        // On affiche le bouton de like (qui fait appel à likeEvent.js) et le label du nombre de likes
                        echo "<img id='img".$reponse['ID_Evenements']."' src='images/thumb%20up.png' ";
                        echo "onclick='likeEvent(".$_SESSION['id'].",".$reponse['ID_Evenements'].",".$likes['COUNT(*)'].",".$usersLike['COUNT(*)'].",\"idea\")' ";
                        echo "alt='Liker' />";
                        echo "<label id='like" . $reponse['ID_Evenements'] . "'>" . $likes['COUNT(*)'] . " like(s)</label>";
                        $likeReq->closeCursor();
                        $userLikeReq->closeCursor() ?>
                    </div>
                    <?php // Si l'utilisateur est membre du BDE, il peut accéder à la gestion de l'idée
                    if ($_SESSION['etat'] == 1) { ?>
                        <button onclick="window.location.assign('?page=submit&id=<?php echo $reponse['ID_Evenements'] ?>')">Gérer cette idée</button>
                    <?php }
                    else if ($_SESSION['etat'] == 2) { ?>
                        <button onclick="">Supprimer cette idée et notifier le BDE</button>
                    <?php } ?>
                </div>
                <?php
            }
        }
        // Si la variable GET "page" vaut "submit", on accède à la page de proposition/gestion d'une idée
        else if ($_GET['page'] == "submit"){
            // La variable boolID vaut par défaut false, et passe à true si l'utilisateur est membre du BDE et que
            // la variable GET "id" est initialisée.
            // Par la suite, cette variable boolID servira à différencier l'affichage en fonction du type d'utilisateur
            $boolID = false;
            if ($_SESSION['etat'])
                $boolID =   isset($_GET['id']);
            // Si boolID vaut true (donc si l'utilisateur est membre du BDE et qu'on gère une idée),
            // on récupère les données liées à l'idée sélectionnée
            if ($boolID) {
                $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

                $ideeReq = $bdd->prepare("SELECT * FROM evenements WHERE ID_Evenements=?");
                $ideeReq->execute(array($_GET["id"]));
                $idee = $ideeReq->fetch();
                $ideeReq->closeCursor();
            }
            // On affiche un titre différent respectivement pour les membres du BDE en train de gérer une idée
            // et les autres visiteurs
            echo "<h1>";
            if ($boolID) { echo "Gestion d'une idée"; } else { echo "Proposition d'une idée"; }
            echo "</h1>";
            // Le formulaire suivant, dans le cas d'une gestion d'idée, est complété par défaut avec les informations
            // de l'idée en question
            ?>
            <form method="POST" action="scripts/addActivity.php<?php echo "?idUser=".$_SESSION['id']; if ($boolID) { echo "&id='".$_GET['id']."'&img='".$idee['Image']."'"; } ?>" autocomplete="on" enctype="multipart/form-data">
                <p>
                    <label for="event">
                        Titre :
                    </label>
                    <input type="text" name="event" id="event" placeholder="Ex: Laser Game" <?php if ($boolID) { echo "value='".$idee['Nom']."'"; } ?> required/>
                    &nbsp;
                    <label for="location">
                        Lieu :
                    </label>
                    <input type="text" name="location" id="location" placeholder="Ex: Orléans" <?php if ($boolID) { echo "value='".$idee['Lieu']."'"; } ?>/>
                    <?php
                    // Ajout d'un champ date pour que les membres du BDE puisse préciser quand aura lieu l'événement
                    if ($boolID) { ?>
                        <label for="date">
                            Date :
                        </label>
                        <input type="date" name="date" id="date" required/>
                    <?php }
                    ?>
                </p>
                <p>
                    <label for="description">
                        Description (255 caractères maximum) :
                    </label>
                    <br/>
                    <textarea name="description" id="description" maxlength="255" required><?php if ($boolID) { echo $idee['Description']; } ?></textarea>
                </p>
                <p>
                    Image :
                    <?php if ($boolID) { echo "<img alt='Miniature originale' class='imgIdee' src='images/Suggestionbox/".$idee['Image']."'/>"; } ?>
                    <input type="file" name="image"/>
                </p>
                <p>
                    <input type="submit" name="upload" <?php if ($boolID) { echo "value='Valider'"; } else { echo "value='Envoyer'"; } ?> />
                    <?php if ($boolID) { echo '<input type="submit" name="delete" value="Supprimer" />'; } ?>
                </p>
            </form>
            <?php
            if (isset($_GET['result']))
                if ($_GET['result'] == 1)
                    echo "<p><strong>Votre proposition a bien été enregistrée, merci !</strong></p>";
        }
    }
    ?>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>