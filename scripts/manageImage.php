<?php

if (isset($_GET['idImg'])) {
    $idImg = $_GET['idImg'];

    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

    $req = $bdd->prepare("DELETE FROM action WHERE Image=?");
    $req->execute(array($idImg));
    $req->closeCursor();

    $req = $bdd->prepare("DELETE FROM image WHERE ID_Image=?");
    $req->execute(array($idImg));
    $req->closeCursor();
}