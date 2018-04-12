<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/boiteAIdee.css"/>
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
        if (!isset($_GET['page'])) { ?>
            <div id="title">
                <h1>Boite à idées</h1>
                <a href="?page=submit"><button>Proposer une idée</button></a>
            </div>
            <?php
            $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

            $ideeReq = $bdd->prepare("SELECT * FROM evenements WHERE Etat = ?");
            $ideeReq->execute(array("0"));

            while ($reponse = $ideeReq->fetch()) { ?>
                <div class='divIdee'>
                    <h4 class='idIdee'>Idée numéro <?php echo $reponse['ID_Evenements']?></h4>
                    <div class='titreIdee'><h3><?php echo $reponse["Nom"] . "&nbsp;" ?></h3>à <?php echo $reponse["Lieu"] ?></div>
                    <div class="contenuIdee">
                        <img src="images/Suggestionbox<?php echo $reponse['Image'] ?>" alt="Image de l'idée" />
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
                        echo "onclick='likeIdea(".$_SESSION['id'].",".$reponse['ID_Evenements'].",".$likes['COUNT(*)'].",".$usersLike['COUNT(*)'].")'";
                        echo " />";
                        echo "<label id='like" . $reponse['ID_Evenements'] . "'>" . $likes['COUNT(*)'] . " like(s)</label>";
                        $likeReq->closeCursor();
                        $userLikeReq->closeCursor() ?>
                    </div>
                </div>
                <?php
            }
        }
        else { ?>
            <h1>Proposition d'une idée</h1>
            <form method="POST" action="scripts/addActivity.php" autocomplete="on" enctype="multipart/form-data">
                <p>
                    <label for="event">
                        Titre :
                    </label>
                    <input type="text" name="event" id="event" placeholder="Ex: Laser Game"/>
                    &nbsp;
                    <label for="location">
                        Lieu :
                    </label>
                    <input type="text" name="location" id="location" placeholder="Ex: Orléans"/>
                </p>
                <p>
                    <label for="description">
                        Description (255 caractères maximum) :
                    </label>
                    <br/>
                    <textarea name="description" id="description" maxlength="255"></textarea>
                </p>
                <p>
                    <label for="image">
                        Image :
                    </label>
                    <input type="file" name="image"/>
                </p>
                <p>
                    <input type="submit" name ="upload" value="Envoyer"/>
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

<script src="javascript/likeIdea.js"></script>

</html>