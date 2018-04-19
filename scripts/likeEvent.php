<?php

// Script permettant d'ajouter ou de retirer un like sur un événement

// Paramètres passés en GET : IDs de l'utilisateur, de l'événement, variable permettant de savoir si l'utilisateur a
// déjà liké l'événement (0 ou 1), et type d'événement (idea ou event)
$idUser = $_GET['user'];
$idEvent = $_GET['event'];
$userLike = $_GET['userLike'];
$eventType = $_GET['eventType'];

$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

// Si l'utilisateur a liké/déliké une idée..
if ($eventType == "idea") {
    // Si l'utilisateur n'avait pas déjà liké, on insère une entrée dans la table vote
    if ($userLike == 0) {
        $requete = $bdd->prepare("INSERT INTO vote (Utilisateur, Evenement) VALUES (?, ?)");
    }
    // Si l'utilisateur avait déjà liké, on supprime son entrée dans la table vote
    else if ($userLike == 1) {
        $requete = $bdd->prepare("DELETE FROM vote WHERE Utilisateur=? AND Evenement=?");
    }
    $requete->execute(array($idUser,$idEvent));
    $requete->closeCursor();
}
// Si l'utilisateur a liké/déliké un événement (passé ou futur)
else if ($eventType == "event") {
    // Si l'utilisateur n'avait pas déjà liké, on regarde s'il a déjà une entrée dans la table
    if ($userLike == 0) {
        $userExistReq = $bdd->prepare("SELECT COUNT(*) FROM `action` WHERE `Utilisateur`=? AND `Image`=?");
        $userExistReq->execute(array($idUser,$idEvent));
        $userExist = $userExistReq->fetch()[0];
        $userExistReq->closeCursor();

        // Si l'utilisateur n'existe pas dans la table, on insère une entrée dans la table de donnée
        if ($userExist == 0) {
            $requete = $bdd->prepare("INSERT INTO `action` (`Utilisateur`, `Image`, `Commentaire`, `Like`) VALUES (?, ?, NULL, '1')");
            $requete->execute(array($idUser, $idEvent));
            $requete->closeCursor();
        }
        // Si l'utilisateur existe déjà dans la table, on passe simplement Like à 1
        else if ($userExist == 1) {
            $requete = $bdd->prepare("UPDATE `action` SET `Like`=1 WHERE `Utilisateur`=? AND `Image`=?");
            $requete->execute(array($idUser,$idEvent));
            $requete->closeCursor();
        }
    }
    // Si l'utilisateur a déjà liké, on passe Like à 0
    else if ($userLike == 1) {
        $requete = $bdd->prepare("UPDATE `action` SET `Like`=0 WHERE `Utilisateur`=? AND `Image`=?");
        $requete->execute(array($idUser,$idEvent));
        $requete->closeCursor();
    }
}
