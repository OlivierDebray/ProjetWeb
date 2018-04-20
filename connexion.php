<?php
session_start();

//on connecte à la bdd
$bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb;charset=utf8', 'root', '');

//Si on appuie sur le bouton "se connecter"
if(isset($_POST['formconnexion']))
{
	$mailconnect = htmlspecialchars($_POST['mailconnect']);
	$mdpconnect = sha1($_POST['mdpconnect']);
    //Si on a bien remplis les deux champs
	if(!empty($mailconnect) AND !empty($mdpconnect))
	{
        //on regarde si l'utilisateur existe bien
		$requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE mail = ? AND motdepasse = ?");
		$requser->execute(array($mailconnect, $mdpconnect));
		$userexist = $requser->rowCount();
        //si il existe, alors on récupère les informations de session
		if ($userexist == 1) 
		{
			$userinfo = $requser->fetch();
			$_SESSION['id'] = $userinfo['ID_Utilisateurs'];
			$_SESSION['nom'] = $userinfo['Nom'];
			$_SESSION['prenom'] = $userinfo['Prenom'];
			$_SESSION['mail'] = $userinfo['Mail'];
            $_SESSION['etat'] = $userinfo['Status'];
            //on redirige l'utilisateur vers son profil avec son id dans l'url
            header("Location: profil.php?id=" . $_SESSION['id']);
		}
		else
		{
			$erreur = "Mauvais mail ou mot de passe";
		}
	}
	else
	{
		$erreur = "Tous les champs doivent être complétés !";
	}
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Connexion | BDE Exia Orléans</title>
    <meta name="description" content="Connectez-vous pour accéder à l'ensemble des services proposés par le site du BDE."/>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/inscription&connexion.css" />
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>

<section id="corpus">

    <div id="formulaire">
		<h1>Connexion</h1>
		<form method="POST" action ="connexion.php">
            <table id="table">
                <tr><td><input class="champ" type="email" name="mailconnect" placeholder="Mail"></td></tr>
                <tr><td><input class="champ" type="password" name="mdpconnect" placeholder="Mot de passe"></td></tr>
                <tr><td><input id="buttonSubmit" type="submit" name="formconnexion" value="Se connecter !"></td></tr>
            </table>
		</form>
		<?php
            //On affiche l'erreur si on rentre pas dans la condition
			if(isset($erreur))
    			echo '<p>' . $erreur . '</p>';
		?>
	</div>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>