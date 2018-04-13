<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb;charset=utf8', 'root', '');

if (isset($_GET['id']) AND ($_GET['id'] > 0))
{
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE ID_Utilisateurs = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/inscription&connexion.css" />
    <script src="javascript/deleteNotification.js"></script>
</head>
<body>

<?php include('includes/header.php') ?>
<?php include('includes/mainNavbar.php') ?>

<section id="corpus">
    <h1>Profil de <?php echo $userinfo['Prenom'] . " " . $userinfo['Nom'] ?></h1>
    <p>Mail : <?php echo $userinfo['Mail']; ?></p>
    <?php
    if (isset($_SESSION['id']) AND $userinfo['ID_Utilisateurs'] == $_SESSION['id'])
    {
        if (isset($_SESSION['etat']) AND $userinfo['Status'] == 0) { ?>
            <a href="">Editer mon profil</a>
        <?php }
        elseif (isset($_SESSION['etat']) AND $userinfo['Status'] == 1) { ?>
            <a href="">Editer mon profil</a>
            <a href="ajoutProduits.php">Ajouter un produit</a>
        <?php }
    } ?>
    <h3>Notifications :</h3>
    <?php
    $notifications = $bdd->prepare("SELECT * FROM notifications WHERE FK_ID_Utilisateur=?");
    $notifications->execute(array($userinfo['ID_Utilisateurs']));
    $i=1;

    while ($notification = $notifications->fetch())
    {
        echo "<div id='divNotif".$notification['ID_Notification']."'>";
        echo "<p>".$i." --> ".$notification['Message']."</p>";
        echo "<button onclick='deleteNotification(".$notification['ID_Notification'].")'>Supprimer</button>";
        echo "</div>";
        $i++;
    }

    $notifications->closeCursor();
    ?>
</section>

<?php include('includes/footer.php'); ?>

</body>
</html>