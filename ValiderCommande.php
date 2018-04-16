<?php session_start()?>

<!DOCTYPE html>
<html>
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/panier.css" />
</head>

<body>
    <?php include ('includes/header.php') ?>
    <?php include('includes/mainNavbar.php') ?>
    <?php include ('includes/shopNavbar.php') ?>
    <section id="corpus">
        <h1>Veuillez choisir votre mode de paiment</h1>    
<button><a href="Paypal.php"> Paypal</a></button>  

<?php

try{
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e){

    die('Erreur:' . $e->getmessage());
}


if(isset($_SESSION["id"])) {
    $id= $_SESSION["id"];

    $client = $bdd->query("SELECT * FROM utilisateurs WHERE ID_Utilisateurs=".$id)->fetch();

    $reqpersonne= $bdd->prepare("SELECT * FROM utilisateurs WHERE Status = '1'");
    $reqpersonne->execute();

    while ($donnée = $reqpersonne->fetch()){

        $message = $client['Nom']." ".$client['Prenom']." a commandé sur le site du BDE. Veuillez lui donner un rendez-vous! ";

        $bdd->query("INSERT INTO notifications (FK_ID_Utilisateur, Message) VALUES ( ".$donnée['ID_Utilisateurs'].",'".addslashes($message)."')");

    }


}

else {
    die("Vous n'êtes pas connecté. Veuillez vous connecter à votre compte pour accéder à votre panier");
}


?>


</section>
</body>

<?php include('includes/footer.php') ?>
</html>