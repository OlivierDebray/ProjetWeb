<?php
$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

$event = $_POST['event'];
$description = $_POST['description'];
$location = $_POST['location'];

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
} else {
    $new_img_name = "activity.png";
}

// Requête préparée pour empêcher les injections SQL
$requete = $bdd->prepare("INSERT INTO evenements (Nom, Description, Lieu, Image, Etat) VALUES( :event, :description, :location, :image, :etat)");

$requete->bindValue(':event', $event, PDO::PARAM_STR);
$requete->bindValue(':description', $description, PDO::PARAM_STR);
$requete->bindValue(':location', $location, PDO::PARAM_STR);
$requete->bindValue(':image', '/'.$new_img_name, PDO::PARAM_STR);
$requete->bindValue(':etat', "0", PDO::PARAM_STR);

$requete->execute();

header('Location:../boiteaidee.php?page=submit&result=1');
?>

