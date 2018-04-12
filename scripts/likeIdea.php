<?php

$idUser = $_GET['user'];
$idIdea = $_GET['idea'];
$userLike = $_GET['userLike'];

$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

if ($userLike == 0) {
    $requete = $bdd->prepare("INSERT INTO vote (Utilisateur, Evenement) VALUES (?, ?)");
    $requete->execute(array($idUser,$idIdea));
    $requete->closeCursor();
}
else if ($userLike == 1) {
    $requete = $bdd->prepare("DELETE FROM vote WHERE Utilisateur=? AND Evenement=?");
    $requete->execute(array($idUser,$idIdea));
    $requete->closeCursor();
}
