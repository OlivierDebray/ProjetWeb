<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb', 'root', '');

if (isset($_GET['id']) AND ($_GET['id'] > 0)) {
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
			?>
                <a href="">Editer mon profil</a>
			<?php
			} ?>
</section>

<?php include('includes/footer.php'); ?>

</body>
</html>