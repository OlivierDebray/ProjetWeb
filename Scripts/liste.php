<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 13/04/2018
 * Time: 17:02
 */

    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root','');

    $searchTerm = $_GET['term'];

    $query = $bdd->prepare("SELECT * FROM Produits WHERE Nom LIKE :term");
    $query->execute(array('term' => '%'.$searchTerm.'%'));

    $array = array();

    while($row = $query->fetch())
    {
        array_push($array, $row['Nom']);
    }

    echo json_encode($array);

