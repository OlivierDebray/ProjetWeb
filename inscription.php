<?php
//on se connecte à la bdd
$bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb;charset=utf8', 'root', '');

// Si on appuie sur le bonton "je m'inscris", alors on récupère les informations des champs du formulaire
if(isset($_POST['forminscription']))
{
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);
    $mdp3 = htmlspecialchars($_POST['mdp']);
    $status = "0";

    //On regarde si les champs ont bien été rempli
    if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    {
        //si le nom depasse pas 255 charactères
        $nomlenght = strlen($nom);
        if ($nomlenght <= 255)
        {
            //si le prénom depasse pas 255 charactères
            $prenomlenght = strlen($prenom);
            if ($prenomlenght <= 255)
            {
                //si les deux mails sont identique
                if ($mail == $mail2)
                {
                    //Valide l'adresse mail
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL))
                    {
                        //on regarde les adresse mail
                        $reqmail = $bdd->prepare("SELECT * FROM utilisateurs WHERE mail = ?");
                        $reqmail->execute(array($mail));
                        $mailexist = $reqmail->rowCount();

                        //si l'adresse mail existe deja
                        if ($mailexist == 0)
                        {
                            //si le mot de passe possede au moins une majuscule, un chiffre et si il fait plus de 8 characteres
                            if (preg_match("~[A-Z]+~", $mdp3) AND preg_match("~[0-9]~", $mdp3) AND strlen($mdp3) > 8)
                            {
                                //si le mot de passe et le mot de passe de vérification sont identique
                                if ($mdp == $mdp2)
                                {
                                    //alors on insert les informations dans la bdd et l'utilisateur et bien inscrit
                                    $insertmbr = $bdd->prepare("INSERT INTO utilisateurs(nom, prenom, mail, motdepasse, status) VALUES (?, ?, ?, ?, ?)");
                                    $insertmbr->execute(array($nom, $prenom, $mail, $mdp, $status));
                                    $erreur = "Votre compte a bien été créé !";
                                }
                                else
                                {
                                    $erreur = "Vos mots de passes ne correspondent pas !";
                                }
                            }
                            else
                            {
                                $erreur = "Veuillez choisir un mot de passe contenant au moins une majuscule, au moins un chiffre et 8 caractères";
                            }
                        }
                        else
                        {
                            $erreur = "Adresse mail déjà utilisée";
                        }
                    }
                    else
                    {
                        $erreur = "Votre adresse mail n'est pas valide !";
                    }
                }
                else
                {
                    $erreur = "Vos adresses ne correspondent pas !";
                }
            }
            else
            {
                $erreur = "Votre prénom ne doit pas dépasser 255 caractères !";
            }
        }
        else
        {
            $erreur = "Votre nom ne doit pas dépasser 255 caractères !";
        }
    }
    else
    {
        $erreur = "Tous les champs doivent être complétés !";

    }
}
?>

<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/inscription&connexion.css" />
    <script src="javascript/validation/inscription.js" ></script>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>

<section id="corpus">

    <div id="formulaire">
        <h1>Inscription</h1>
        <form method="POST" action="inscription.php">
            <table id="table">
                <tr>
                    <td class="label">
                        <label for="nom">Nom :</label>
                    </td>
                    <td>
                        <input class="champ" type="text" placeholder="Votre nom" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>" onblur="verifLength(this,25)"/>
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        <label for="prenom">Prénom :</label>
                    </td>
                    <td>
                        <input class="champ" type="text" placeholder="Votre prénom" id="prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>" onblur="verifLength(this,25)"/>
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        <label for="mail">Mail :</label>
                    </td>
                    <td>
                        <input class="champ" type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" onblur="verifMail(this,document.getElementById('mail2'))"/>
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        <label for="mail2">Confirmation du mail :</label>
                    </td>
                    <td>
                        <input class="champ" type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" onblur="verifMail(this,document.getElementById('mail'))"/>
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        <label for="mdp">Mot de passe :</label>
                    </td>
                    <td>
                        <input class="champ" type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"/>
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        <label for="mdp2">Confirmation du mot de passe :</label>
                    </td>
                    <td>
                        <input class="champ" type="password" placeholder="Confirmez votre mot de passe" id="mdp2" name="mdp2"/>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input id="buttonSubmit" type="submit" name="forminscription" value="Je m'inscris" />
                    </td>
                </tr>

            </table>

            <p id="paraErreur">
            </p>

            <?php
            // lorsque qu'on arrive pas a rentrer dans une boucle on affiche l'erreur correspondante
            if (isset($erreur))
                echo "<p>" . $erreur . "</p>";
            ?>

        </form>
    </div>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>

