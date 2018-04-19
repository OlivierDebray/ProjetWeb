<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 16/04/2018
 * Time: 10:11
 */

        //connexion à la BDD
        $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root','');

        //attribut q correspond au nom du produit taper par l'utilisateur
        //attribut prix correspond au choix de tri sélectionner décroissant ou croissant
        //Si la page a un attribut q et que cet attribut  n'est pas vide et que l'attribut prix est n'est pas attribué

        if (isset($_GET['q']) AND !empty($_GET['q']) AND !isset($_GET['prix']) )
        {
            // on récupère la valeur du nom tapé dans le champ de recherche
            $q = $_GET['q'];

            //on cherche les produits correspondant au nom entré
            $query = $bdd->query('SELECT * FROM produits
        WHERE Nom LIKE "%'.$q.'%" ');

            //Appel du Script d'affichage
            include ('AfficherProduit.php');

        }
        else if (isset($_GET['q']) AND !empty($_GET['q']) AND isset($_GET['prix']) AND !empty($_GET['prix'])){

            // on récupère la valeur du nom tapé dans le champ de recherche et du tri selectionner (croissant ou décroissant)
            $q = $_GET['q'];
            $prix = $_GET['prix'];

            //on cherche les produits correspondant au nom entré et on tri en fonction du choix sélectionné
            $query = $bdd->query('SELECT * FROM produits WHERE Nom LIKE "%'.$q.'%" ORDER BY Prix '.$prix.' ');

            //Appel du Script d'affichage
            include ('AfficherProduit.php');

        }
        else{ ?>
            <p>Veuillez Inscrire le nom du produit recherché</p>
<?php }