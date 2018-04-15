<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 13/04/2018
 * Time: 17:02
 */

    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root','');

    $searchTerm = $_GET['term'];

    $query = $bdd->query("SELECT * FROM Produits WHERE Nom LIKE '%".$searchTerm."%' ORDER BY Nom ASC");

    while($row = $query->fetch_assoc())
    {
        $data[] = $row['Nom'];
    }

    echo json_encode($data);

