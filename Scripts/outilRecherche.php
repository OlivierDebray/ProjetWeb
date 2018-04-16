<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 16/04/2018
 * Time: 10:11
 */

        $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root','');

        $getName = $_GET['q'];
        $getPrix = $_GET['prix'];


        if (isset($getName) && !empty($getName )){

            $q = htmlspecialchars($getName);

            $query = $bdd->query('SELECT * FROM produits
        WHERE Nom LIKE "%'.$q.'%" ');


            include ('AfficherProduit.php');

        }
        else if (isset($getName) && !empty($getName) && isset($getPrix) && !empty($getPrix )){

            $q = htmlspecialchars($getName);
            $prix = htmlspecialchars($getPrix);

            $query = $bdd->query('SELECT * FROM produits WHERE Nom LIKE "%'.$q.'%" ORDER BY Prix '.$prix.' ');

            include ('AfficherProduit.php');

        }

