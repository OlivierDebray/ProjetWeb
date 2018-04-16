<?php

// Script permettant de supprimer une notification de la table notifications
if (isset($_GET['id'])) {
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

    $deleteReq = $bdd->prepare("DELETE FROM notifications WHERE ID_Notification=?");
    $deleteReq->execute(array($_GET['id']));
    $deleteReq->closeCursor();
}