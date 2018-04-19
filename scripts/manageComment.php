<?php

$idPhoto = $_POST['photo'];
$idUser = $_POST['user'];
if (isset($_POST['message']))
    $message = $_POST['message'];

$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');



// On regarde si l'utilisateur a déjà une entrée dans la table
$userExistReq = $bdd->prepare("SELECT COUNT(*) FROM `action` WHERE `Utilisateur`=? AND `Image`=?");
$userExistReq->execute(array($idUser,$idPhoto));
$userExist = $userExistReq->fetch()[0];
$userExistReq->closeCursor();

// Si l'utilisateur n'existe pas dans la table, on insère une entrée dans la table de données
if ($userExist == 0) {
    $req = $bdd->prepare("INSERT INTO `action` (`Utilisateur`, `Image`, `Commentaire`, `Like`) VALUES (?, ?, ?, NULL)");
    $req->execute(array($idUser, $idPhoto, $message));
    $req->closeCursor();
}
// Si l'utilisateur existe déjà dans la table, on update Commentaire
else if ($userExist == 1) {
    if (!isset($_POST['mode'])) {
        $requete = $bdd->prepare("UPDATE `action` SET `Commentaire`=? WHERE `Utilisateur`=? AND `Image`=?");
        $requete->execute(array($message, $idUser, $idPhoto));
    }
    else if ($_POST['mode'] == "delete") {
        $requete = $bdd->prepare("UPDATE `action` SET `Commentaire`=NULL WHERE `Utilisateur`=? AND `Image`=?");
        $requete->execute(array($idUser, $idPhoto));
    }
    $requete->closeCursor();
}