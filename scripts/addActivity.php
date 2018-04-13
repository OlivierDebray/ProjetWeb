<?php
$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

$event = $_POST['event'];
$description = $_POST['description'];
$location = $_POST['location'];
$delete = $_POST['delete'];
$date = $_POST['date'];

if (empty($delete)) {
    if(!empty($_FILES['image']['name']) AND isset($_FILES['image'])){
        $image = $_FILES['image'];
        $tmpname = $image['tmp_name'];
        $extension = explode('.', $image['name']);
        $image_extension = strtolower(end($extension));
        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
        $date = getdate();
        $new_img_name = $date['mday'].$date['mon'].$date['year'].'_'.$date['hours'].$date['minutes'].$date['seconds'].'.'.$image_extension;
        $target = "../images/Suggestionbox/".$new_img_name;

        if(in_array($image_extension, $allowed)){
            move_uploaded_file($tmpname,$target);
        }
    } else if (isset($_GET['img'])) {
        $new_img_name = $_GET['img'];
    } else {
        $new_img_name = "/activity.png";
    }

    if (!isset($_GET['id'])) {
        // Requête préparée pour empêcher les injections SQL
        $requete = $bdd->prepare("INSERT INTO evenements (Nom, Description, Lieu, Image, Etat) VALUES( :event, :description, :location, :image, :etat)");
        $requete->bindValue(':event', $event, PDO::PARAM_STR);
        $requete->bindValue(':description', $description, PDO::PARAM_STR);
        $requete->bindValue(':location', $location, PDO::PARAM_STR);
        $requete->bindValue(':image', '/'.$new_img_name, PDO::PARAM_STR);
        $requete->bindValue(':etat', "0", PDO::PARAM_STR);
        $requete->execute();
        $requete->closeCursor();
    }
    else {
        $bdd->query("DELETE FROM vote WHERE Evenement=".$_GET['id']);
        $bdd->query("UPDATE evenements SET Nom='".$event."', Description='".addslashes($description)."', Date='".$date."', Lieu='".$location."', Etat=1 WHERE ID_Evenements=".$_GET['id']);
        $bdd->query("UPDATE evenements SET Image='/".$new_img_name."' WHERE ID_Evenements=".$_GET['id']);

        $idUser = $bdd->query("SELECT UtilisateurCreateur FROM evenements WHERE ID_Evenements=".$_GET['id'])->fetch();
        $message = "Félicitations, votre idée \"".$event."\" a été acceptée et aura lieu le ".$date.". Merci de votre participation !";
        $bdd->query("INSERT INTO notifications (FK_ID_Utilisateur, Message) VALUES (".$idUser['UtilisateurCreateur'].",'".addslashes($message)."')");
    }
}
else if ($delete == "Supprimer") {
    $bdd->query("DELETE FROM vote WHERE Evenement=".$_GET['id']);
    $bdd->query("DELETE FROM evenements WHERE ID_Evenements=".$_GET['id']);
}

header('Location:../boiteaidee.php?page=submit&result=1');
?>

