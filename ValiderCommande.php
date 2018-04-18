<?php session_start()?>

<!DOCTYPE html>
<html>
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/panier.css" />
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    
</head>

<body>
    <?php include ('includes/header.php') ?>
    <?php include('includes/mainNavbar.php') ?>
    <?php include ('includes/shopNavbar.php') ?>
    <section id="corpus">
        <h1>Veuillez choisir votre mode de paiement</h1>    
        <div id="bouton-paypal"></div>

        <?php

        try{
            $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }

        catch(Exception $e){

            die('Erreur:' . $e->getmessage());
        }


        if(isset($_SESSION["id"])) {
            $id= $_SESSION["id"];

            $client = $bdd->query("SELECT * FROM utilisateurs WHERE ID_Utilisateurs=".$id)->fetch();
            $commande = $bdd->query("SELECT * FROM panier WHERE Utilisateur = '$id'");

            $reqpersonne= $bdd->prepare("SELECT * FROM utilisateurs WHERE Status = '1'");
            $reqpersonne->execute();

            while ($donnée = $reqpersonne->fetch()){

                $message = $client['Nom']." ".$client['Prenom']." a commandé sur le site du BDE. Veuillez le contacter afin de lui donner un rendez-vous à l'adresse mail: " .$client['Mail'];

                $bdd->query("INSERT INTO notifications (FK_ID_Utilisateur, Message) VALUES ( ".$donnée['ID_Utilisateurs'].",'".addslashes($message)."')");
            }

            while ($produitsCommande = $commande->fetch()) {
                $bdd->query("INSERT INTO commande (Utilisateur, Produit, Date, Quantité) VALUES (".$id.",'".$produitsCommande['Produit']."',now(),".$produitsCommande['Quantite'].")");
            }

            $bdd->query("DELETE FROM panier WHERE Utilisateur = '$id'");

        }

        else {
            die("Vous n'êtes pas connecté. Veuillez vous connecter à votre compte pour accéder à votre panier");
        }


        ?>


    </section>

    <script>
        paypal.Button.render({
      env: 'sandbox', // Ou 'production',
      commit: true, // Affiche le bouton  "Payer maintenant"
      style: {
        color: 'gold', // ou 'blue', 'silver', 'black'
        size: 'responsive' // ou 'small', 'medium', 'large'
        // Autres options de style disponibles ici : https://developer.paypal.com/docs/integration/direct/express-checkout/integration-jsv4/customize-button/
    },
    payment: function(data, actions) {
        /* 
         * Création du paiement
         */
         console.log('paiement créé');
     },
     onAuthorize: function(data, actions) {
        /* 
         * Exécution du paiement 
         */
     },
     onCancel: function(data, actions) {
        /* 
         * L'acheteur a annulé le paiement
         */
     },
     onError: function(err) {
        /* 
         * Une erreur est survenue durant le paiement 
         */
     }
 }, '#bouton-paypal');
</script>
</script>
</body>

<?php include('includes/footer.php') ?>
</html>