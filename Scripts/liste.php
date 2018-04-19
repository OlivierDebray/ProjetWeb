<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 13/04/2018
 * Time: 17:02
 */

/*
 * Ce Script permet de rechercher tous les noms de produits dans la base de données et de les afficher dans la liste de suggestion
 * de l'autocompletion
 */
    //connexion à la BDD
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root','');

    // On recupère le terme recherche
    $searchTerm = $_GET['term'];

    //Requete de sélection des noms dans la table prouits quand le nom correspond au terme entré par l'utilisateur
    $query = $bdd->prepare("SELECT Nom FROM Produits WHERE Nom LIKE :term");
    $query->execute(array('term' => '%'.$searchTerm.'%'));

    $array = array();

    while($row = $query->fetch())
    {
        //recupère toutes les occurences de noms de la requête et les inscrit dans un tableau
        array_push($array, $row['Nom']);
    }

    //Encode dans un Json le résultat de la boucle while
    echo json_encode($array);

