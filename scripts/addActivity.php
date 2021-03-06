<?php
// Script PHP permettant d'ajouter et de gérer les idées

$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Paramètres envoyés en GET à la fonction : l'ID de l'idée, sa description, 
$event = $_POST['event'];
$description = $_POST['description'];
$location = $_POST['location'];
$delete = $_POST['delete'];
$date = $_POST['date'];

if (isset($_POST['id']))
    $idEvent = $_POST['id'];
if (isset($_GET['id']))
    $idEvent = $_GET['id'];

// Si le bouton delete n'existe pas
if (empty($delete)) {
    /*
     * Si une image a bien été insérée dans le lien
     * On stocke l'array récupérée dans une variable
     * On stocke le chemin tmp dans une variable
     * On stocke l'extension récupérée de l'image, dans une variable
     * On convertit l'extension de l'image récupérée en minuscule
     * On définit dans une array les extensions acceptées
     * On stocke dans une variable la date actuelle
     * On stocke le nom de l'image constitué de la date et du temps, suivis de l'extension dans une variable
     * On stocke le chemin où sera sauvegardée l'image dans une variable
    */

    if(!empty($_FILES['image']['name']) AND isset($_FILES['image'])){
        $image = $_FILES['image'];
        $tmpname = $image['tmp_name'];
        $extension = explode('.', $image['name']);
        $image_extension = strtolower(end($extension));
        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
        $date = getdate();
        $new_img_name = $date['mday'].$date['mon'].$date['year'].'_'.$date['hours'].$date['minutes'].$date['seconds'].'.'.$image_extension;
        $target = "../images/Suggestionbox/".$new_img_name;

        /*
         * Si l'extension de l'image insérée correspond aux extensions autorisées
         * On déplace l'image insérée au chemin indiqué
        */
        if(in_array($image_extension, $allowed)){
            move_uploaded_file($tmpname,$target);
        }
    /*
     * Si un membre du BDE insère lui-même une image
     * On stocke le nom de l'image insérée par le membre du BDE
    */
    } else if (isset($_GET['img'])) {
        $new_img_name = $_GET['img'];

    /*
     * S'il n'y a pas d'image insérée
     * On définit une image par défaut
    */
    } else {
        $new_img_name = "activity.png";
    }

    /*
     * S'il n'y a pas d'ID spécifié en GET
     * On récupère les données entrées par l'utilisateur et on les insère dans la table
    */
    if (!isset($_GET['id'])) {
        // Requête préparée pour empêcher les injections SQL
        $requete = $bdd->prepare("INSERT INTO evenements (Nom, UtilisateurCreateur, Description, Lieu, Image, Etat) VALUES( :event, :userCreator, :description, :location, :image, 0)");
        $requete->bindValue(':event', $event, PDO::PARAM_STR);
        $requete->bindValue(':userCreator', $_GET['idUser'], PDO::PARAM_STR);
        $requete->bindValue(':description', $description, PDO::PARAM_STR);
        $requete->bindValue(':location', $location, PDO::PARAM_STR);
        $requete->bindValue(':image', '/'.$new_img_name, PDO::PARAM_STR);
        $requete->execute();
        $requete->closeCursor();
    }

    /*
     * Si un ID est spécifié dans le GET
     * On retire les votes de l'idée
     * On met à jour l'idée
     * On notifie l'utilisateur
    */
    else {
        $bdd->query("DELETE FROM vote WHERE Evenement=".$_GET['id']);
        $bdd->query("UPDATE evenements SET Nom='".$event."', Description='".addslashes($description)."', Date='".$date."', Lieu='".$location."', Etat=1 WHERE ID_Evenements=".$_GET['id']);
        $bdd->query("UPDATE evenements SET Image='/".$new_img_name."' WHERE ID_Evenements=".$_GET['id']);

        $idUser = $bdd->query("SELECT UtilisateurCreateur FROM evenements WHERE ID_Evenements=".$_GET['id'])->fetch();
        $message = "Félicitations, votre idée \"".$event."\" a été acceptée et aura lieu le ".$date.". Merci de votre participation !";
        $bdd->query("INSERT INTO notifications (FK_ID_Utilisateur, Message) VALUES (".$idUser['UtilisateurCreateur'].",'".addslashes($message)."')");
    }
}

/*
 * Si le bouton delete existe et que l'on clique dessus
 * On retire les votes de l'idée
 * On supprime l'idée
*/
else if ($delete == "Supprimer") {
    $bdd->query("DELETE FROM vote WHERE Evenement=".$idEvent);
    $bdd->query("DELETE FROM participation WHERE Evenement=".$idEvent);
    $req = $bdd->query("DELETE FROM `evenements` WHERE `ID_Evenements`=".$idEvent);
}

//header('Location:../boiteaidee.php?page=submit&result=1');
?>