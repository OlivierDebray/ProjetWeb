<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 16/04/2018
 * Time: 10:11
 */

        $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root','');



        if (isset($_GET['q']) AND !empty($_GET['q']) AND !isset($_GET['prix']) AND empty($_GET['prix']))
        {

            $q = htmlspecialchars($_GET['q']);

            $query = $bdd->query('SELECT * FROM produits
        WHERE Nom LIKE "%'.$q.'%" ');

            include ('AfficherProduit.php');

        }
        else if (isset($_GET['q']) AND !empty($_GET['q']) AND isset($_GET['prix']) AND !empty($_GET['prix'])){

            $q = htmlspecialchars($_GET['q']);
            $prix = htmlspecialchars($_GET['prix']);

            $query = $bdd->query('SELECT * FROM produits WHERE Nom LIKE "%'.$q.'%" ORDER BY Prix '.$prix.' ');

            include ('AfficherProduit.php');

        }
        else{ ?>
            <p>Veuillez Inscrire le nom du produit recherché</p>
<?php }