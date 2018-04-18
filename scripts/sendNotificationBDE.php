<?php

if (isset($_POST['message'])) {
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

    $BDEmembers = $bdd->query("SELECT * FROM utilisateurs WHERE Status=1");

    while ($aMember = $BDEmembers->fetch()) {
        $bdd->query("INSERT INTO notifications (FK_ID_Utilisateur, Message) VALUES (".$aMember['ID_Utilisateurs'].",'".addslashes($_POST['message'])."')");
    }
}