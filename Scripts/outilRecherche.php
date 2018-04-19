<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 16/04/2018
 * Time: 10:11
 */

        //connexion à la BDD
        $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root','');


        //Si la page a une valeur q = nom et que cette variable n'est pas vide et que la variable prix est n'est pas attribué

        if (isset($_GET['q']) AND !empty($_GET['q']) AND !isset($_GET['prix']) )
        {
            // on récupère la valeur du nom entrer dans le champ de recherche
            $q = $_GET['q'];

            //on cherche les prodiuits correspondant au nom entré
            $query = $bdd->query('SELECT * FROM produits
        WHERE Nom LIKE "%'.$q.'%" ');

            //Appel du Script d'affichage
            include ('AfficherProduit.php');

        }
        else if (isset($_GET['q']) AND !empty($_GET['q']) AND isset($_GET['prix']) AND !empty($_GET['prix'])){

            $q = $_GET['q'];
            $prix = $_GET['prix'];

            $query = $bdd->query('SELECT * FROM produits WHERE Nom LIKE "%'.$q.'%" ORDER BY Prix '.$prix.' ');

            include ('AfficherProduit.php');

        }
        else{ ?>
            <p>Veuillez Inscrire le nom du produit recherché</p>
<?php }