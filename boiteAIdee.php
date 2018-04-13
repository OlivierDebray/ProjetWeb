<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/boiteAIdee.css"/>
    <script src="javascript/likeIdea.js"></script>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>
<?php include('includes/eventNavbar.php') ?>

<section id="corpus">
    <?php
    if (!isset($_SESSION['id'])) { ?>
        <h1>Boite à idée</h1>
        <p>Vous devez être connecté pour voir la boite à idée et y contribuer !</p>
    <?php }
    else {
        if (!isset($_GET['page'])) {
            $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

            $req = $bdd->prepare("SELECT Status FROM utilisateurs WHERE ID_Utilisateurs=?");
            $req->execute(array($_SESSION['id']));
            $status = $req->fetch();
            $req->closeCursor();
            $status = $status['Status'];
            ?>

            <div id="title">
                <h1>Boite à idées</h1>
                <button onclick="window.location.assign('?page=submit')">Proposer une idée</button>
            </div>

            <?php
            $ideeReq = $bdd->prepare("SELECT * FROM evenements WHERE Etat = ?");
            $ideeReq->execute(array("0"));

            while ($reponse = $ideeReq->fetch()) { ?>
                <div class='divIdee'>
                    <h4 class='idIdee'>Idée numéro <?php echo $reponse['ID_Evenements']?></h4>
                    <div class='titreIdee'><h3><?php echo $reponse["Nom"] . "&nbsp;" ?></h3>à <?php echo $reponse["Lieu"] ?></div>
                    <div class="contenuIdee">
                        <img class="imgIdee" src="images/Suggestionbox<?php echo $reponse['Image'] ?>" alt="Image de l'idée" />
                        <p><?php echo $reponse['Description'] ?></p>
                    </div>
                    <div class="userAction">
                        <?php $likeReq = $bdd->prepare("SELECT COUNT(*) FROM vote WHERE Evenement=?");
                        $likeReq->execute(array($reponse['ID_Evenements']));
                        $likes = $likeReq->fetch();

                        $userLikeReq = $bdd->prepare("SELECT COUNT(*) FROM vote WHERE Utilisateur=? AND Evenement=?");
                        $userLikeReq->execute(array($_SESSION['id'],$reponse['ID_Evenements']));
                        $usersLike = $userLikeReq->fetch();

                        echo "<img id='img".$reponse['ID_Evenements']."' src='images/thumb%20up.png' ";
                        echo "onclick='likeIdea(".$_SESSION['id'].",".$reponse['ID_Evenements'].",".$likes['COUNT(*)'].",".$usersLike['COUNT(*)'].")' ";
                        echo "alt='Miniature originale' />";
                        echo "<label id='like" . $reponse['ID_Evenements'] . "'>" . $likes['COUNT(*)'] . " like(s)</label>";
                        $likeReq->closeCursor();
                        $userLikeReq->closeCursor() ?>
                    </div>
                    <?php if ($status == 1) { ?>
                        <a href="?page=submit&id=<?php echo $reponse['ID_Evenements'] ?>">Gérer cette idée</a>
                    <?php } ?>
                </div>
                <?php
            }
        }
        else if ($_GET['page'] == "submit"){
            $boolID = isset($_GET['id']);
            if ($boolID) {
                $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

                $ideeReq = $bdd->prepare("SELECT * FROM evenements WHERE ID_Evenements=?");
                $ideeReq->execute(array($_GET["id"]));
                $idee = $ideeReq->fetch();
                $ideeReq->closeCursor();
            }
            echo "<h1>";
            if ($boolID) { echo "Gestion d'une idée"; } else { echo "Proposition d'une idée"; }
            echo "</h1>";
            ?>
            <form method="POST" action="scripts/addActivity.php<?php echo "?idUser=".$_SESSION['id']; if ($boolID) { echo "&id='".$_GET['id']."'&img='".$idee['Image']."'"; } ?>" autocomplete="on" enctype="multipart/form-data">
                <p>
                    <label for="event">
                        Titre :
                    </label>
                    <input type="text" name="event" id="event" placeholder="Ex: Laser Game" <?php if ($boolID) { echo "value='".$idee['Nom']."'"; } ?>/>
                    &nbsp;
                    <label for="location">
                        Lieu :
                    </label>
                    <input type="text" name="location" id="location" placeholder="Ex: Orléans" <?php if ($boolID) { echo "value='".$idee['Lieu']."'"; } ?>/>
                    <?php
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
                    <textarea name="description" id="description" maxlength="255"><?php if ($boolID) { echo $idee['Description']; } ?></textarea>
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