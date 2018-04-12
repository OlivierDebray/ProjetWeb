<?php

$idUser = $_GET['user'];
$idIdea = $_GET['idea'];

$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

$requete = $bdd->prepare("INSERT INTO vote (Utilisateur, Evenement) VALUES (?, ?)");
$requete->execute(array($idUser,$idIdea));

$requete->closeCursor();