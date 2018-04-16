<?php
// Script PHP permettant l'inscription à un événement de la base de données

// Paramètres passés en GET : IDs de l'utilisateur, de l'événement, variable permettant de savoir si l'utilisateur a
// déjà liké l'événement (0 ou 1), et type d'événement (idea ou event)
$idUser = $_GET['user'];
$idEvent = $_GET['event'];
$participation = $_GET['participation'];

$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

// Si l'utilisateur ne participe pas déjà à l'événement, on insère une entrée correspondante dans la table
if ($participation == 0) {
    $req = $bdd->prepare("INSERT INTO participation (Utilisateur, Evenement) VALUES (?, ?)");
    $req->execute(array($idUser, $idEvent));
    $req->closeCursor();
}
// Si l'utilisateur participe déjà à l'événement, on supprime son entrée de la base de données
else {
    $req = $bdd->prepare("DELETE FROM participation WHERE Utilisateur=? AND Evenement=?");
    $req->execute(array($idUser, $idEvent));
    $req->closeCursor();
}